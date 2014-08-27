	<link rel="stylesheet" href="<?=base_url('css/flag-stylesheet.css');?>" type="text/css" />
	<link rel="stylesheet" href="<?=base_url('js/anythingslider/css/anythingslider.css');?>" />
	<link rel="stylesheet" href="<?=base_url('css/theme-anythingslider-scielo.css');?>" />
	<link rel="stylesheet" href="<?=base_url('css/jquery.slider.min.css');?>" />
	<link href="<?=base_url('css/jquery.bxslider.css');?>" rel="stylesheet" />
	<script src="<?=base_url('js/jquery.bxslider.min.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('js/jquery.slider.min.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('js/anythingslider/js/jquery.anythingslider.min.js');?>"></script>
	<script src="<?=base_url('js/d3.js');?>"></script>
	<script src="<?=base_url('js/d3.layout.cloud.js');?>"></script>
	<script type="text/javascript" language="javascript">
		jQuery(document).ready(function()
		{
			var w = 480,
			h = 300;
			var fill = d3.scale.category20c();
			var fontSize = d3.scale.log().range([10, 100]);
			d3.layout.cloud().size([w, h])
				.words([
<?php 
					$totalDisciplinas = count($disciplinas);
					$indexOfDisciplina = 1;
					foreach ($disciplinas as $disciplina):?>
					{text: "<?=mb_strtolower($disciplina['disciplina'], 'UTF-8');?>", size: "<?=number_format((11 + ($disciplina['size'] * 1.8)), '2', '.', '');?>", link: "<?=site_url("indice/disciplina/{$disciplina['slug']}");?>"}<?php 
					if($indexOfDisciplina < $totalDisciplinas):
					echo ",\n";
					endif;
					$indexOfDisciplina++;
					endforeach;
?>])
				.rotate(function(d) { return 0; })
				.font("Impact")
				.fontSize(function(d) { console.log(d); return d.size; })
				.on("end", draw)
				.start();

			function draw(words) {
				d3.select("div.tagCloud").append("svg")
					.attr("width", w)
					.attr("height", h)
					.append("g")
					.attr("transform", "translate(" + [w >> 1, h >> 1] + ")")
					.selectAll("text")
					.data(words)
					.enter().append("text")
					.style("font-size", function(d) { return d.size + "px"; })
					.style("font-family", "Impact")
					.style("fill", "#333333")
					.on("click", function(d) {window.location = d.link;})
					.attr("text-anchor", "middle")
					.attr("transform", function(d) { return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")"; })
					.text(function(d) { return d.text; });
			}
			jQuery('#bxsliderPais').bxSlider({
				minSlides: 2,
				maxSlides: 2,
				slideMargin: 100,
				auto: true,
				pager: false,
				slideWidth: 126,
				slideHeigth: 126,
				captions: true
			});
			jQuery('#bxsliderMain').bxSlider({
				pause: 6000,
				auto: true,
				randomStart: true,
				speed: 500,
				pager: false
				});
			jQuery('#bxsliderIndicadores').bxSlider({
				auto: true,
				speed: 1500,
				controls: false
			});
			jQuery("#accordion").accordion({
				header: "h3",
				collapsible: true,
				autoHeight: true,
				navigation: true 
			});
		});
	</script>
	