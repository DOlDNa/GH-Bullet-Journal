<?php
header('Last-Modified: '. $last_modified = gmdate('D, d M Y H:i:s T', getlastmod()));
if (filter_input(INPUT_SERVER, 'HTTP_IF_MODIFIED_SINCE') === $last_modified) header('HTTP/1.1 304 Not Modified');
header('Content-Type: text/css');
echo file_get_contents('groundwork.css')?>legend label{float:left}.graph:after{border:10px solid transparent;border-top-color:rgba(0,0,0,.6);bottom:9px;content:'';left:48%}.graph:before,.graph:after{opacity:0;position:absolute;transition:all .5s ease-in-out}.graph:before{background:rgba(0,0,0,.6);color:white;content:attr(data-tooltip);display:block;left:43%;padding:10px 0;top:0px;min-width:80px;text-align:center}.graph:hover:after{opacity:1;bottom:6px}.graph:hover:before{opacity:1;top:3px}.graph{cursor:crosshair;position:relative}#gauge span{left:0;position:absolute;text-align:right;width:100%;white-space:nowrap;width:3em;z-index:1000}#gauge{border:0;width:3em;font-size:xx-small;position:relative;vertical-align:top}#rate td,#rate th{padding:0;position:relative}#rate td:before{border-bottom:1px dotted white;content:'';display:block;position:absolute;top:50%;width:100%}#rate,#th th{border:0}#schedule{height:8em}*{font-weight:normal!important}.bar{animation:a 1s;align-self:flex-end;background-color:#2ecc71;height:5em;width:100%}.box{border-radius:0;position:inherit}.dark{color:#dbdbdc;background-color:#3b3b3b;border:0}.graph{background-color:rgba(255,255,255,.1);display:flex;height:5em;width:100%}.icon-check-empty{padding-right:2px}.page-top{background-color:rgba(255,255,255,.1);bottom:0;padding:1em .5em;position:fixed;right:0;z-index:1010}.schedule{font-family:TakaoPGothic,"Noto Sans CJK JP",sans-serif;vertical-align:top;width:100%;word-break:break-word!important;word-wrap:break-word!important;white-space:pre-wrap!important;font-size:large}.separate{border-collapse:separate;border-spacing:0 5px;border:0}.th{padding:0;text-align:center;vertical-align:middle;width:4em}.th a,.th span{display:block;padding:.5em 1em;white-space:nowrap}.th span{color:#9a9a9a}a:hover{color:#ffffff}a{color:#dbdbdc}del{animation:b 1s ease-out forwards;background-image:linear-gradient(limegreen,limegreen);background-position:0 51%;background-repeat:no-repeat;text-decoration:none}fieldset label{display:inline-flex}html,body{background-color:#3b3b3b;color:#dbdbdc}input.button,input[type=date],input[type=month],input[type=number],textarea{border:none}input.button{letter-spacing:5px;padding:10px}input[type=date],input[type=month],input[type=number],fieldset,textarea{background:inherit;color:inherit}input[type=radio]+label:hover,input[type=radio]:checked+label{text-shadow:none}input[type=radio]+label{cursor:pointer;padding:5px 7px;box-shadow:0 2px 2px rgba(0,0,0,.3);text-shadow:0 1px 1px #bbb}input[type=radio]:checked+label{cursor:inherit;box-shadow:inset 0 2px 2px rgba(0,0,0,.3)}main{margin:2em}table td{padding:5px 8px;font-size:1em}table td,table th,table tr:nth-child(2n) th,table tr:nth-child(2n) td{background:inherit}td.button{letter-spacing:2px;padding:10px;white-space:nowrap;display:table-cell}textarea{padding:1em}th a,.th span{font-size:x-large}th,td{border:thin solid #dbdbdc}@keyframes a{from{height:0}}@keyframes b{from{background-size:0% 3px}to{background-size:100% 3px}}@media(max-width:1024px){main{margin:1em}caption.double-gap-bottom{margin:5px;padding:0}td.button{font-size:small!important;padding:.2em!important}}@media print{#table{margin:0 auto!important;width:70%!important}#rate td{text-align:right!important}#th th{text-align:left!important}#rate td span{height:1em!important}#rate td:after{content:attr(title)!important}*{font-size:11pt!important;color:#000000!important}.alert,.alert del{color:goldenrod!important}.error,.error del{color:red!important}.info,.info del{color:blue!important}.success,.success del{color:green!important}.th,.td{padding:0 10px!important;border:1px solid #000000!important}.th{text-align:right!important;padding:0!important;white-space:nowrap!important}.white,.white del{color:lightgray!important}caption,thead,td[class="button blue square"],td[class="button red square"],.icon-check,.icon-check-empty,#gauge{display:none!important}del{text-decoration:line-through!important}html,body,table,th,td{border:none!important;margin:0!important;padding:0!important}td.button{vertical-align:middle!important}}
