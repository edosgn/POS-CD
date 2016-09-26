<?php
namespace AppBundle\Twig\Extension;

class PosExtension extends \Twig_Extension{
	
	public function getFilters(){
		return array(
			'cuenta_atras'=>new \Twig_Filter_Method($this, 'cuentaAtras', array('is_safe'=>array('html'))),);
	}

	public function cuentaAtras($fecha){
		$fecha=$fecha->format('Y,')
				.($fecha->format('m')-1)
				.$fecha->format(',d,H,i,s');
		$html=<<<EOJ
<script type="text/javascript">
function muestraCuentaAtras(){
var horas, minutos, segundos;
var ahora = new Date();
var fechaEntrega = new Date($fecha);
var falta = Math.floor((fechaEntrega.getTime() - ahora.getTime())/1000);
if (falta < 0) {
cuentaAtras = '-';
}
else{
horas = Math.floor(falta/3600);
falta = falta % 3600;
minutos = Math.floor(falta/60);
falta = falta % 60;
segundos = Math.floor(falta);
cuentaAtras = (horas < 10 ? '0' + horas : horas) + 'h '
+ (minutos < 10 ? '0' + minutos : minutos) + 'm '
+ (segundos < 10 ? '0' + segundos : segundos) + 's ';
setTimeout('muestraCuentaAtras()', 1000);
}
document.getElementById('tiempo').innerHTML = '<h2>Faltan: ' + cuentaAtras + '</h2>';
}
muestraCuentaAtras();
</script>
EOJ;
		return $html;
	}

	public function getName(){
		return 'pos';
	}
}