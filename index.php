<?php
  $channel_id = "UCNsidkYpIAQ4QaufptQBPHQ" ;
  $vids = GetVideos($channel_id);
  foreach($vids as $vid){
    echo $vid;
    echo '<br>';
  }
  //https://hi3103.net/notes/web/1297
  function GetVideos($channel_id){
    
    // フィードのURL
    $url = "https://www.youtube.com/feeds/videos.xml?channel_id=".$channel_id ;
    echo $url ;
    //フィードを読み込み
    $xml = simplexml_load_file($url);
    //配列に変換
    $obj = get_object_vars($xml);
    //動画情報を変数に格納
    $obj_entry = $obj["entry"];
    //動画のトータル件数を取得
    $total = count($obj_entry);
    $videos = array();
    //動画が存在するかどうかチェック
    if( $total != 0 ){
      //リストの開始タグを出力
      for ($i=0; $i < $total; $i++) { 
        foreach ($obj_entry[$i] as $key => $value) {
          if( in_array($key, array('id','title')) ){//キーがidかtitleの場合
            if( $key=='id'){
              //動画IDを変数に格納（yt:video:XXXXという形式なので手前の文字列を置換処理も挟む）
              $video_id = str_replace('yt:video:', '', $value[0]);
              $videos[] = $video_id;
            }
          }else{
            continue;//残りの処理をスキップ
          }
        }
   
      }
      //リストの終了タグを出力
    }
    return $videos;
  }

?>