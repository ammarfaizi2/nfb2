<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php js("crayner"); ?>
</head>
<body>
<iframe id="fr" style="width:70%;height:500px;" src="<?php print router_url()."/iframe?user=".$_GET['user']; ?>"></iframe>
<?php js("as"); ?>
<script type="text/javascript">
class as
{
	constructor(){
		this.crayner	= new crayner;
		this.offset 	= 0;
	}
	act(){
		this.crayner.xhr("GET","/iframe/geturl?offset="+this.offset,
			function(){
				var x;
				try{
					x = JSON.parse(this.responseText);
				} catch(e){ x = null; }
				this.element		= document.getElementById('fr');
				this.element.src	= "<?php print router_url()."/iframe?user=".$_GET['user']; ?>&add="+encodeURI(x[0]);
			});
		this.offset++;
	}
}
	var a = new as;
	setInterval(function(){
		a.act();
	},10000);
</script>
</body>
</html>