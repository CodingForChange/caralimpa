<!Doctype html>
<html>
	<head>
		<meta charset="utf-8" />

		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>">
		<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow:400,700' rel='stylesheet' type='text/css'>	</head>

	<body>
		<div id="container">
			<header>
				<hgroup>
					<h1>Cara Limpa</h1>
					<h2><em>Veja como você está sendo representado<br>pelos Senadores brasileiros</em></h2>
				</hgroup>
			</header>
				<?php
				$hackton            = new Hackton_Intercon_2012();
				$votacaoes_nominais = $hackton->get_votacoes_nominais();
				foreach( $votacaoes_nominais->Votacoes->Votacao as $votacao ) :
				?>
				<section>
					<h1 id="codigo-votacao-<?php echo $votacao->CodigoSessaoVotacao; ?>"><?php echo $votacao->DescricaoVotacao; ?> (<?php echo $votacao->SiglaMateria; ?>)</h1>
					<small><em>Iniciada em <?php echo date( 'd/m/Y', strtotime( $votacao->DataSessao ) ); ?> às <?php echo $votacao->HoraInicio; ?></em></small>
					<h2>Votação</h2>
					<?php
					$votos_by_type = Hackton_Intercon_2012::get_votos_by_type( $votacao->Votos );
					foreach( $votos_by_type as $voto_type => $voto_data ) :
					?>
					
					<?php
					/**
					 * localhost/hackton-intercon-2012/#codigo-votacao-5025?codigo_votacao=5025&voto_type=p-rnv
					 * Não ocultar via CSS quado existir esses param na URL. Asssim exibimos os parlamentares quando o usuário
					 * vir do link no Facebook
					 */
					$class_name     = 'hide';
					$codigo_votacao = null;
					$voto_tipo      = null;
					
					$pog = null;
					if ( isset( $_GET['pog'] ) ) :
						$pog            = esc_html( $_GET['pog'] );
						$pog_parts      = explode( '|', $pog );
						$codigo_votacao = $pog_parts[0];
						$voto_tipo      = $pog_parts[1];
					endif;

					if ( !empty( $codigo_votacao ) )
						$codigo_votacao = intval( $codigo_votacao );
					
					if ( !empty( $voto_tipo ) )
						$voto_tipo = esc_html( $voto_tipo );

					$codigo_votacao_api = (int) $votacao->CodigoSessaoVotacao;
					$voto_tipo_api      = sanitize_title( $voto_type );

					if ( ( $codigo_votacao == $codigo_votacao_api ) and ( $voto_tipo == $voto_tipo_api ) )
						$class_name = 'show';

					$share_url = sprintf( '%s/?pog=%d|%s', Hackton_Intercon_2012::APP_URL, $codigo_votacao_api, $voto_tipo_api );
					$share_summary = sprintf( 'Veja quais Senadores votaram %s na ementa %s. Você está sendo bem representado pelos Senadores brasileiros?', $voto_type, $votacao->DescricaoVotacao );
					?>	
					<h3><a href="javascript:;" class="btn-toggle-votes"><?php echo $voto_type; ?></a></h3>
					<div class="<?php echo $class_name; ?>">
						<a class="facebook" target="_blank" href="http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo Hackton_Intercon_2012::APP_TITLE; ?>&p[url]=<?php echo $share_url; ?>&p[summary]=<?php echo $share_summary; ?>&p[images][0]=http://www.uribrasil.org.br/site/wp-content/uploads/2010/06/brasil.jpg" title=""><span>Compartilhe no Facebook os Senadores que Votaram</span></a>
						<ol>
							<?php foreach( $voto_data as $data ) : ?>
							<li>
								<div class="thumbnail">
									<a href="<?php echo $data['url']; ?>" title="<?php echo $data['parlamentar']; ?>">
										<img src="<?php echo $data['foto']; ?>" width="40" height="40" alt="<?php echo $data['parlamentar']; ?>" />
									</a>
								</div>
								<time class="data">
									<?php echo $data['parlamentar']; ?> (<?php echo $data['sexo']; ?>)
								</time>
							</li>
							<?php endforeach; ?>
						</ol>
					</div>
						
					<?php endforeach; ?>
					
				</section>
				<?php 
				endforeach; 
				?>
		
		</div>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript">
		jQuery( function() {
			
			jQuery( '.btn-toggle-votes' ).click( function() {
				jQuery( this ).parent().toggleClass( 'active' ).next( 'div' ).slideToggle();
			})
		});
		</script>

	</body>
</html> 