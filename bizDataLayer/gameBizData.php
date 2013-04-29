<?php
//include exceptions
require_once('./bizDataLayer/exception.php');

//if we have gotten here - we know:
//-they have permissions to be here
//-we are ready to do something with the database
//-method calling these are in the svcLayer
//-method calling specific method has same name droping 'Data' at end checkTurnData() here is called by checkTurn() in svcLayer


/*************************
	startData
	
*/
function startData($gameId){
	global $mysqli;
	//return $gameId.'sdf';
	//simple test for THIS 'game' - resets the last move and such to empty
	$sql = "UPDATE checkers_games SET player0_pieceID=null, player0_boardI=null, player0_boardJ=null, player1_pieceID=null, player1_boardI=null, player1_boardJ=null WHERE game_id=?";
	try{
		if($stmt=$mysqli->prepare($sql)){
			//bind parameters for the markers (s - string, i - int, d - double, b - blob)
			$stmt->bind_param("i",$gameId);
			$stmt->execute();
			$stmt->close();
		}else{
        	throw new Exception("An error occurred while setting up data");
        }
	}catch (Exception $e) {
        log_error($e, $sql, null);
		return false;
    }
	//get the init of the game
	$sql = "SELECT * FROM checkers_games WHERE game_id=?";
	try{
		if($stmt=$mysqli->prepare($sql)){
			//bind parameters for the markers (s - string, i - int, d - double, b - blob)
			$stmt->bind_param("i",$gameId);
			$data=returnJson($stmt);
			$mysqli->close();
			return $data;
		}else{
            throw new Exception("An error occurred while fetching record data");
        }
	}catch (Exception $e) {
        log_error($e, $sql, null);
		return false;
    }
}
/*************************
	checkTurnData
*/
function checkTurnData($gameId){
	global $mysqli;
	$sql="SELECT whoseTurn FROM checkers_games WHERE game_id=?";
	try{
		if($stmt=$mysqli->prepare($sql)){
			$stmt->bind_param("i",$gameId);
			$data=returnJson($stmt);
			$mysqli->close();
			return $data;
		}else{
        	throw new Exception("An error occurred while checking turn");
        }
    }catch (Exception $e) {
        log_error($e, $sql, null);
		return false;
    }
}
/*************************
	changeTurnData
*/
function changeTurnData($gameId){
	global $mysqli;
	//ugly, but toggle the turn (if the turn was 0, then make it 1, else make it 0)
	try{
		if($stmt=$mysqli->prepare("UPDATE checkers_games SET whoseTurn='2' WHERE game_id=? AND whoseTurn='0'")){
			$stmt->bind_param("i",$gameId);
			$stmt->execute();
			$stmt->close();
		}else{
        	throw new Exception("An error occurred while changing turn, step 1");
        }
		if($stmt=$mysqli->prepare("UPDATE checkers_games SET whoseTurn='0' WHERE game_id=? AND whoseTurn='1'")){
			$stmt->bind_param("i",$gameId);
			$stmt->execute();
			$stmt->close();
		}else{
        	throw new Exception("An error occurred while changing turn, step 2");
        }
		if($stmt=$mysqli->prepare("UPDATE checkers_games SET whoseTurn='1' WHERE game_id=? AND whoseTurn='2'")){
			$stmt->bind_param("i",$gameId);
			$stmt->execute();
			$stmt->close();
		}else{
        	throw new Exception("An error occurred while changing turn, step 3");
        }
	}catch (Exception $e) {
        log_error($e, $sql, null);
		return false;
    }
	$mysqli->close();
}
/*************************
	changeBoardData
*/
function changeBoardData($gameId,$pieceId,$boardI,$boardJ,$playerId){
	//update the board
	global $mysqli;
	$sql="UPDATE checkers_games SET player".$playerId."_pieceId=?, player".$playerId."_boardI=?, player".$playerId."_boardJ=? WHERE game_id=?";
	try{
		if($stmt=$mysqli->prepare($sql)){
			$stmt->bind_param("siii",$pieceId,$boardI,$boardJ,$gameId);
			$stmt->execute();
			$stmt->close();
		}else{
        	throw new Exception("An error occurred while changeBoard");
        }
	}catch (Exception $e) {
        log_error($e, $sql, null);
		return false;
    }
	$mysqli->close();
}
/*************************
	getMoveData
*/
function getMoveData($gameId){
	global $mysqli;
	$sql="SELECT * FROM checkers_games WHERE game_id=?";
	try{
		if($stmt=$mysqli->prepare($sql)){
			$stmt->bind_param("i",$gameId);
			$data=returnJson($stmt);
			$mysqli->close();
			return $data;
		}else{
			throw new Exception("An error occurred while getMoveData");
		}
	}catch (Exception $e) {
        log_error($e, $sql, null);
		return false;
    }
}
/*********************************Utilities*********************************/
/*************************
	returnJson
	takes: prepared statement
		-parameters already bound
	returns: json encoded multi-dimensional associative array
*/
function returnJson ($stmt){
	$stmt->execute();
	$stmt->store_result();
 	$meta = $stmt->result_metadata();
    $bindVarsArray = array();
	//using the stmt, get it's metadata (so we can get the name of the name=val pair for the associate array)!
	while ($column = $meta->fetch_field()) {
    	$bindVarsArray[] = &$results[$column->name];
    }
	//bind it!
	call_user_func_array(array($stmt, 'bind_result'), $bindVarsArray);
	//now, go through each row returned,
	while($stmt->fetch()) {
    	$clone = array();
        foreach ($results as $k => $v) {
        	$clone[$k] = $v;
        }
        $data[] = $clone;
    }
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	//MUST change the content-type
	header("Content-Type:text/plain");
	// This will become the response value for the XMLHttpRequest object
    return json_encode($data);
}
?>