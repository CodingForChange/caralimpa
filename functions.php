<?php
class Hackton_Intercon_2012 {

	const URL = 'http://legis.senado.gov.br/dadosabertos/dados/ListaVotacoes2012.xml';

	const APP_TITLE = 'Cara Limpa';

	const APP_URL = 'http://localhost/hackton-intercon-2012';

	/**
	 * Lista de votações nominais de 2012
	 */
	public function get_votacoes_nominais( $year = 2012 ) {
		$results = wp_remote_retrieve_body( wp_remote_get( self::URL ) );
		$results = simplexml_load_string( $results );
		return $results;
	}

	public function get_votos_by_type( $data ) {
		$votos = null;
		foreach( $data->VotoParlamentar as $voto ) :
			$voto_type = (string) trim( $voto->Voto );
			$votos[$voto_type][] = array(
				'parlamentar' => (string)$voto->NomeParlamentar,
				'foto'        => (string)$voto->Foto,
				'url'         => (string)$voto->Url,
				'sexo'        => (string)$voto->SexoParlamentar
			);
		endforeach;
		return $votos;
	}

}

// add_action( 'after_setup_theme', '_setup' );

// function _setup() {
// 	echo get_bloginfo( 'template_url' ) . '/js/script.js';
// 	add_action('wp_enqueue_scripts', 'scripts' );
// }

// function scripts() {
// 	exit( 'opa' );
// 	wp_enqueue_script( 'script-teste', get_bloginfo( 'template_url' ) . '/js/script.js', array( 'jquery' ) );
// }


// // Lista de votações em plenário e votos registrados no ano de 2012 

// // $results = wp_remote_retrieve_body( wp_remote_get( $url ) );
// // $results = wp_remote_retrieve_body( wp_remote_get( $url ) );

// $results = simplexml_load_file( $url );

// foreach( (array)$results->Votacoes as $votacao ) :
// 	// echo '<pre>';
// 	// print_r($votacao);
// 	// exit;
// 	$i = 0;
// 	foreach( $votacao as $votacao ) :
// 		echo $votacao->DescricaoVotacao;
		
// 		foreach( $votacao->Votos as $voto ) 
// 			echo  ' - # ' . count( $voto->VotoParlamentar );
// 		endforeach;
		
// 		echo '<hr>';

// 	endforeach;
	
// endforeach;
