<script language="javascript" src="lz-string.min.js"></script>
<script>
var string = "[-3042658.3485956867, 4911518.530419475, 2694490.762397115, -0.48275330038473135, 0.7624817463461793, 0.4307793373138153, -0.5513928284780334, -0.6467906427260879, 0.5269039885832791]";        
console.log("Size of sample is: " + string.length);         
var compressed = LZString.compress(string);         
console.log("Size of compressed sample is: " + compressed.length);         
console.log(compressed);         
string = LZString.decompress(compressed);         
console.log("Sample is: " + string);
</script>