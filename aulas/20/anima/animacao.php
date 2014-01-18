<style>
canvas#jogo{
	background:yellow;
}
</style>
<div id="fundo">
	<canvas id="jogo"	width="960"	height="510"></canvas>
</div>

<script>
var MDown = false;
var Color = 'blue';

var Canvas = document.getElementById('jogo');
var Context = Canvas.getContext('2d');

Canvas.onselectstart = function() { return false; };
Canvas.unselectable = "on";
Canvas.style.MozUserSelect = "none";

Canvas.onmousedown = function(e) {
    MDown = true;
    Context.strokeStyle = Color;
    Context.lineWidth = 3;
    Context.lineCap = 'round';
    Context.beginPath();
    Context.moveTo(e.pageX - Position(Canvas).left, e.pageY - 5);
}

Canvas.onmouseup = function() { MDown = false; };

Canvas.onmousemove = function(e) { 
    if (MDown) {
        Context.lineTo(e.pageX - Position(Canvas).left, e.pageY - 5);
        Context.stroke();
    }
}

function Position(el) {
    var position = {left: 0, top: 0};
    if (el) {
        if (!isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
            position.left += el.offsetLeft;
            position.top += el.offsetTop;
        }
    }
    return position;
}
</script>