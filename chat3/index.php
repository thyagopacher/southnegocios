<?php
session_start();
include "../sistema/model/Conexao.php";
$conexao = new Conexao();
?> 
<!doctype html>
<html>
    <head>
        <meta charset='UTF-8' />
        <style>
            input, textarea {border:1px solid #CCC;margin:0px;padding:0px}

            #body {max-width:800px;margin:auto}
            #log {width:100%;height:400px}
            #message {width:100%;line-height:20px}
        </style>
        <script src="/sistema/visao/recursos/js/jquery-2.0.0.min.js"></script>
        <script src="fancywebsocket.js"></script>
        <script>
            var Server;

            function send(text) {
                Server.send('message', text);
            }

            $(document).ready(function () {
                /**pesquisa dos logados*/
                $("#nome_pesquisado").keyup(function () {
                    $.ajax({
                        url: "../sistema/control/VerificaLogados2.php",
                        type: "POST",
                        data: {nome_pesquisado: document.getElementById("nome_pesquisado").value},
                        dataType: 'text',
                        success: function (data, textStatus, jqXHR) {
                            $(".infinite-list-viewport").html(data);
                        }, error: function (jqXHR, textStatus, errorThrown) {
                            swal("Erro ao procurar", "Erro causado por:" + errorThrown, "error");
                        }
                    });
                });

                console.log('Connecting...');
                Server = new FancyWebSocket('ws://gestccon.com.br:9300');

                $('#message').keypress(function (e) {
                    if (e.keyCode == 13 && this.value) {
                        send(this.value);
                        $(this).val('');
                    }
                });

                //Let the user know we're connected
                Server.bind('open', function () {
                    console.log("Connected.");
                    $("#message").attr("disabled", false);
                });

                //OH NOES! Disconnection occurred.
                Server.bind('close', function (data) {
                    console.log("Disconnected.");
                    $("#message").attr("disabled", true);
                });

                //Log any messages sent from server
                Server.bind('message', function (payload) {
                    var msg = JSON.parse(payload);
                    var type = msg.type; //message type
                    var umsg = msg.message; //message text                          
                    var hoje = new Date;
                    var situacao = 'in';
                    if (type == 'usermsg' && (msg.codpessoa1 == <?= $_SESSION['codpessoa'] ?> || msg.codpessoa2 == <?= $_SESSION['codpessoa'] ?>)) {
                        if (msg.codpessoa1 == <?= $_SESSION['codpessoa'] ?>) {
                            situacao = 'out';
                        }
                        if(msg.codpessoa1 !== document.getElementById("codpessoa2").value){
                           trocaPessoaFalando(msg.codpessoa1);
                        }
                        var mensagem_recebida = '';
                        mensagem_recebida += "<div class='msg' id='chat'>";
                        mensagem_recebida += '<div class="message message-' + situacao + ' tail">';
                        mensagem_recebida += "<div class='bubble bubble-text'>";
                        mensagem_recebida += "<div class='message-text'>";
                        mensagem_recebida += "<span class='message-pre-text'>";
                        mensagem_recebida += "<span>";
                        mensagem_recebida += "[<?= date('d/m/Y') ?>," + hoje.getHours() + ":" + hoje.getMinutes + "]";
                        mensagem_recebida += "</span>";
                        mensagem_recebida += "</span>";
                        mensagem_recebida += "<span class='emojitext selectable-text' dir='auto'>";
                        mensagem_recebida += umsg;
                        mensagem_recebida += "</span>";
                        mensagem_recebida += "</div>";
                        mensagem_recebida += "<div class='message-meta'>";
                        mensagem_recebida += "<span class='hidden-token'>";
                        mensagem_recebida += "<span class='message-datetime'>";
                        mensagem_recebida += hoje.getHours() + ":" + hoje.getMinutes();
                        mensagem_recebida += "</span>";
                        mensagem_recebida += "</span>";
                        mensagem_recebida += "</div>";
                        mensagem_recebida += "</div>";
                        mensagem_recebida += "</div>";
                        mensagem_recebida += "</div>";
                        $('.message-list').append(mensagem_recebida);
                    }
                    if (type == 'system') {
                        $('#message_box').append("<div class=\"system_msg\">" + umsg + "</div>");
                    }

                    $('#message').val(''); //reset text                            
                });

                Server.connect();
            });
        </script>
    </head>

    <body>
        <div id='body'>
            <textarea id='log' name='log' readonly='readonly'></textarea><br/>
            <input type='text' id='message' name='message' disabled/>
        </div>
    </body>

</html>