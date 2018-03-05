<?php


function benjamin_get_quote_markup($quote = null) {
    if( !is_array($quote) || !isset($quote['author']) || !isset($quote['body']) )
        return;

    $output = '';
    $output .= '<blockquote class="blockquote--header">';
        $output .= '<p>'.$quote['body'].'</p>';
        $output .= '<cite>'.$quote['author'].'</cite>';
    $output .= '</blockquote>';

    return $output;
}


function benjamin_get_chat_log($chat = null) {
    if(!$chat || empty($chat) || empty($chat['messages']))
        return;

    $messages = $chat['messages'];
    $style = 'graphical';

    $output = '';
    $output .= '<ol class="chat-log">';

    foreach($messages as $message){
        $output .= '<li class="chat-log__message chat-log__author-'.$message['authorID'].'">';
            $output .= '<h6 class="chat-log__author">'.$message['displayName'].'</h6>';
            $output .= '<p class="chat-log__text">'.$message['text'].'</p>';
        $output .= '</li>';
    }
    $output .= '</ol>';

    return $output;
}
