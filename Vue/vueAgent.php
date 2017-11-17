<?php 
	$titre = 'Agent'; 
	ob_start();
?>
<p>Bienvenu Mr l'agent, que désirez-vous faire?</p>
<?php
	$contenu = ob_get_clean();
	require_once 'gabarit.php'
?>