<?php
	$title = 'List of movies';
	include('common.php');
	
	// import list of movies
	$string = file_get_contents('../films.json', FILE_USE_INCLUDE_PATH);
	$brut = json_decode($string, true);
	$top = $brut['feed']['entry'];
	
	function find_movie_index_by_name($name, $array) {
		return array_search( $name, array_column( array_column($array, 'im:name'), 'label' ) );
	}
?>
		<p><a href='../films.json'>Display the list of movies</a></p>
		<p>Top 10 movies:</p>
		<ol>
			<?php
				for ( $index = 0; $index < 10; $index++ ) {
					if ( $index > 0 ) { echo "\t\t\t"; }
					echo '<li>'.$top[$index]['im:name']['label'].'</li>'."\n";
				}
			?>
		</ol>
		<p>
			Ranking of the movie "Gravity":<br />
			<?php
				$index = find_movie_index_by_name('Gravity', $top);
				echo ($index + 1)."\n";
			?>
		</p>
		<p>
			Director of "The LEGO Movie":<br />
			<?php
				$index = find_movie_index_by_name('The LEGO Movie', $top);
				echo $top[$index]['im:artist']['label']."\n";
			?>
		</p>
		<p>
			Number of movies released before 2000:<br />
			<?php
				$count = 0;
				foreach ( $top as $movie ) {
					if ( explode('-', $movie['im:releaseDate']['label'])[0] < 2000 ) {
						$count++;
					}
				}
				echo $count."\n";
			?>
		</p>
	</body>
</html>
