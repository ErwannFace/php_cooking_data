<?php
	$title = 'Dictionary';
	include('common.php');
	
	// import dictionary
	$string = file_get_contents('../dictionnaire.txt', FILE_USE_INCLUDE_PATH);
	$dico = explode("\n", $string);
?>
		<p>
			Number of words in the dictionary:<br />
			<?php
				echo count($dico)."\n";
			?>
		</p>
		<p>
			Number of 15 letters words in the dictionary:<br />
			<?php
				$total = 0;
				foreach( $dico as $word ) {
					if ( strlen($word) == 15 ) { $total++; }
				}
				echo $total."\n";
			?>
		</p>
		<p>
			Number of words in the dictionary containing the letter 'w':<br />
			<?php
				$total = 0;
				foreach( $dico as $word ) {
					if ( preg_match('/w/i', $word) ) { $total++; }
				}
				echo $total."\n";
			?>
		</p>
		<p>
			Number of words in the dictionary ending with the letter 'q':<br />
			<?php
				$total = 0;
				foreach( $dico as $word ) {
					if ( preg_match('/q$/', $word) ) { $total++; }
				}
				echo $total."\n";
			?>
		</p>
	</body>
</html>
