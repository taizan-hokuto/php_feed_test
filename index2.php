<?php
  $api_key = ""; //APIキーを入力
  $video_id = ""; //動画ID（11文字）を入力

  if ($api_key == "" || $video_id == ""){
    echo "ソースのAPIキーまたは動画IDが空欄になっています";
    return;
  }
  echo "[GetLiveStatus]<br>";
  echo GetLiveStatus($video_id, $api_key);
  echo '<br>'.'<br>';


  echo "[GetOtherStatus]<br>";
  $status = GetOtherStatus($video_id, $api_key);
  echo "動画タイトル: ";
  echo $status['snippet']['title'].'<br>';
  echo "配信ステータス: ";
  echo $status['snippet']['liveBroadcastContent'].'<br>';
  echo "開始時間: ";
  echo $status['liveStreamingDetails']['actualStartTime'].'<br>';
  echo "終了時間: ";
  if (isset($status['liveStreamingDetails']['actualEndTime'])){
      echo $status['liveStreamingDetails']['actualEndTime'];
    }
    echo "開始時間: ";
    echo $status['liveStreamingDetails']['actualStartTime'].'<br>';
    
  
  function GetLiveStatus($video_id, $api_key){
    //1回あたりのapiコスト：3
    //戻り値：'live'⇒ライブ配信中、'upcoming'⇒配信予約、'none'⇒アーカイブ済み、'error'⇒動画IDまたはAPIキーが誤っている"
    $url = "https://www.googleapis.com/youtube/v3/videos?part=snippet&fields=items(id,snippet(liveBroadcastContent))&id=".$video_id."&key=".$api_key;

    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
    $result = curl_exec( $ch );
    curl_close( $ch );

    $data = json_decode($result, true);
    $key = $data['items'];
     if (count($data['items']) == 0) {
       return 'error';
     }
    return $data['items'][0]['snippet']['liveBroadcastContent'];
  }



  function GetOtherStatus($video_id, $api_key){
    //複数のフラグを取得するサンプル"
    //1回あたりのapiコスト：約
    $url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,liveStreamingDetails&fields=items(id,snippet(title,liveBroadcastContent),liveStreamingDetails(actualStartTime,actualEndTime,concurrentViewers))&id=".$video_id."&key=".$api_key;

    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
    $result = curl_exec( $ch );
    curl_close( $ch );

    $data = json_decode($result, true);
    $key = $data['items'];
     if (count($data['items']) == 0) {
      return 'error';
       return null;
     }
    return $data['items'][0];
  }

  
?>