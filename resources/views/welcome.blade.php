<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<img id="cam"/>
<video src="http://rexlab.ufsc.br:8072" width="320" height="240" controls>
não rolou
</video>


<script>
function refreshImg() {
	$("#cam").attr("src", "http://150.162.232.4:8073/motion/snapshot.jpg?" + (Math.round(Math.random(1000)*1000)));
	setTimeout("refreshImg();", 100);
}
$(document).ready(function() {
	refreshImg();
});

</script>