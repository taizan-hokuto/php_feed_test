<?php
  //https://hi3103.net/notes/web/1297

  $channel_id = "UCNsidkYpIAQ4QaufptQBPHQ" ;
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
  //動画が存在するかどうかチェック
  if( $total != 0 ){
    //リストの開始タグを出力
    echo '<ul>';
    for ($i=0; $i < $total; $i++) { 
      foreach ($obj_entry[$i] as $key => $value) {
        if( in_array($key, array('id','title')) ){//キーがidかtitleの場合
          if( $key=='id'){
            //動画IDを変数に格納（yt:video:XXXXという形式なので手前の文字列を置換処理も挟む）
            $video_id = str_replace('yt:video:', '', $value[0]);
          }elseif( $key=='title' ){
            //動画タイトルを変数に格納
            $video_title = $value[0];
          }
        }else{
          continue;//残りの処理をスキップ
        }
      }
      //リスト形式で出力
      echo '<li>';
      echo '<a href="https://www.youtube.com/watch?v='.$video_id.'">';//動画IDを使ってURLを組み立て
      echo $video_title;//動画タイトル
      echo '</a>';
      echo '</li>';
    }
    //リストの終了タグを出力
    echo '</ul>';
  }


?>