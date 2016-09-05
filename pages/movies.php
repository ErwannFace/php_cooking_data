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
	
	function return_label($label, $index, $array) {
		return $array[$index][$label]['label'];
	}
?>
		<p><a href='../films.json'>Display the list of movies</a></p>
		<p>Top 10 movies:</p>
		<ol>
			<?php
				for ( $index = 0; $index < 10; $index++ ) {
					if ( $index > 0 ) { echo "\t\t\t"; }
					echo '<li>'.return_label('im:name', $index, $top).'</li>'."\n";
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
				echo return_label('im:artist', $index, $top)."\n";
			?>
		</p>
		<p>
			Number of movies released before 2000:<br />
			<?php
				$count = 0;
				foreach ( $top as $index => $movie ) {
					if ( return_label('im:releaseDate', $index, $top) < '2000' ) {
						$count++;
					}
				}
				echo $count."\n";
			?>
		</p>
		<p>
			Most recent movie:<br />
			<?php
				$movies_sorted_by_release = array();
				foreach ( $top as $index => $movie ) {
					$date = return_label('im:releaseDate', $index, $top);
					$title = return_label('im:name', $index, $top);
					$movies_sorted_by_release[$title] = $date;
				}
				arsort($movies_sorted_by_release);
				echo key($movies_sorted_by_release)."\n";
			?>
		</p>
		<p>
			Oldest movie:<br />
			<?php
				asort($movies_sorted_by_release);
				echo key($movies_sorted_by_release)."\n";
			?>
		</p>
		<p>
			Most represented category:<br />
			<?php
				$categories = array();
				foreach ( $top as $index => $movie ) {
					$category = $movie['category']['attributes']['label'];
					$categories[$category] = ( isset($categories[$category]) ) ? $categories[$category] + 1 : 1;
				}
				arsort($categories);
				echo key($categories)."\n";
			?>
		</p>
		<p>
			Most present director in the top 100:<br />
			<?php
				$directors = array();
				foreach ( $top as $index => $movie ) {
					$director = return_label('im:artist', $index, $top);
					$directors[$director] = ( isset($directors[$director]) ) ? $directors[$director] + 1 : 1;
				}
				arsort($directors);
				echo key($directors)."\n";
			?>
		</p>
		<p>
			Cost to buy the top 10 on iTunes:<br />
			<?php
				$total = 0;
				for ( $index = 0; $index < 10; $index++ ) {
					$price = explode( '$', return_label('im:price', $index, $top) )[1];
					$total += $price;
				}
				echo '$'.number_format($total, 2)."\n";
			?>
		</p>
		<p>
			Cost to rent the top 10 on iTunes:<br />
			<?php
				$total = 0;
				for ( $index = 0; $index < 10; $index++ ) {
					$price = explode( '$', return_label('im:rentalPrice', $index, $top) )[1];
					$total += $price;
				}
				echo '$'.number_format($total, 2)."\n";
			?>
		</p>
		<p>
			Month with the most cinema releases:<br />
			<?php
				$releases_by_month = array();
				foreach ( $top as $index => $movie ) {
					$month = explode( ' ', $movie['im:releaseDate']['attributes']['label'])[0];
					$releases_by_month[$month] = ( isset($releases_by_month[$month]) ) ? $releases_by_month[$month] + 1 : 1;
				}
				arsort($releases_by_month);
				echo key($releases_by_month)."\n";
			?>
		</p>
		<p>Top 10 movies to buy with a limited budget:</p>
		<?php
			$movies_by_buying_price = array();
			foreach ( $top as $index => $movie ) {
				$price = explode( '$', return_label('im:price', $index, $top) )[1];
				$title = return_label('im:name', $index, $top);
				$movies_by_buying_price[$title] = $price;
			}
			asort($movies_by_buying_price);
		?>
		<ol>
			<?php
				for ($index = 0; $index < 10; $index++) {
					echo '<li>'.key($movies_by_buying_price).'</li>'."\n";
					array_shift($movies_by_buying_price);
				}
			?>
		</ol>
		<p>Top 10 movies to rent with a limited budget:</p>
		<?php
			$movies_by_rental_price = array();
			foreach ( $top as $index => $movie ) {
				if ( ! empty(return_label('im:rentalPrice', $index, $top)) ) {
					$price = explode( '$', return_label('im:rentalPrice', $index, $top) )[1];
					$title = return_label('im:name', $index, $top);
					$movies_by_rental_price[$title] = $price;
				}
			}
			asort($movies_by_rental_price);
		?>
		<ol>
			<?php
				for ($index = 0; $index < 10; $index++) {
					echo '<li>'.key($movies_by_rental_price).'</li>'."\n";
					array_shift($movies_by_rental_price);
				}
			?>
		</ol>
	</body>
</html>
