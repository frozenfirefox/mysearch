<?php
header("Content-type:text/html;charset=UTF-8");

$dir = '.';

function loop($dir) {
    $file = scandir($dir);
    foreach ($file as $v) {
        if (!is_dir($dir . "/" . $v)) {
            echo $dir . "/" . $v . "<br/>";
        } else if (is_dir($dir . "/" . $v) && $v <> '..' && $v <> '.') {
            loop($dir . "/" . $v);
        }
    }
}

$file = scandir($dir);
foreach ($file as $f) {
    if (is_file($f)) {
        $data[] = iconv("GB2312", "UTF-8", "$f");
    }
}
$data = json_encode(array_filter($data));
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            body{
                margin:0;
                padding:0;
                background-color:gray;
            }
            .search{
                width:100%;
                height:100px;
                padding-top:300px;
                text-align:center;	
            }
            .input{
                padding-left:20px;
                padding-right:20px;
                width:500px;
                height:60px;   
                border-radius:60px;
                font-size:30px;
            }
            p{
                margin:0 auto;
                width:500px;
                height:auto;
                line-height:30px;
                border:1px solid #333;
            }
        </style>
    </head>
    <body onload="init();">
        <div class="search">
            <h1>水滴互联搜索</h1>
            <input id="search" type="text" name="search" class="input" onkeyup="javascript:tip(this.value);" onfocus="this.style = 'background-color:yellow;'" onblur="this.style = 'background-color:white;'" value="" placeholder="shuidihulian search">
            <a href="javascript:goto();">水滴一下</a>
            <p id="tip" style="display: none;">
            </p>
        </div>
        <script>
            function $(a) {
                return document.getElementById(a);
            }
            function goto() {
                window.open($("search").value);
            }
            function init() {
                document.getElementsByTagName("body").height = window.screen.height + "px";
            }           
            function select(p) {
                $("search").value = p;
                $("tip").style = "display:none;";
                $("tip").innerHTML = "";
            }
            function tip(value) {
                var html = "";
                var data = <?php echo $data; ?>;
                for (var v in data) {
                    var flag = data[v].toLowerCase().indexOf(value.toLowerCase());
                    if (flag > -1) {
                        html += "<a href=\"javascript:select('" + data[v] + "');\">" + data[v] + "</a><br/>";
                    }
                }
                if (value != '') {
                    $("tip").innerHTML = html;
                    if (html == '') {
                        $("tip").style = "display:none;";
                    } else {
                        $("tip").style = "display:block;";
                    }

                } else {
                    $("tip").style = "display:none;";
                    $("tip").innerHTML = "";
                }
            }
            function hide() {
                $("tip").style = "display:none;";
                $("tip").innerHTML = "";
            }
        </script>
    </body>
</html>
