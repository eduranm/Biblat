	<script src="<?php echo base_url();?>js/d3.js"></script>
	<script src="<?php echo base_url();?>js/d3.layout.cloud.js"></script>
	<script type="text/javascript" language="javascript">
		jQuery(document).ready(function()
		{
			var w = 480,
			h = 300;
			var fill = d3.scale.category20();
			var fontSize = d3.scale.log().range([10, 100]);
			d3.layout.cloud().size([w, h])
				.words([
<?php 
					$totalDisciplinas = count($disciplinas);
					$indexOfDisciplina = 1;
					foreach ($disciplinas as $disciplina):?>
					{text: "<?php echo strtolower($disciplina['disciplina']);?>", size: "<?php echo number_format((11 + ($disciplina['size'] * 1.8)), '2', '.', '');?>", link: "<?php echo site_url("indice/disciplina/{$disciplina['slug']}");?>"}<?php 
					if($indexOfDisciplina < $totalDisciplinas):
					echo ",\n";
					endif;
					$indexOfDisciplina++;
					endforeach;
?>])
				.rotate(function(d) { return ~~(Math.random() * 5) * 30 - 70; })
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
					.style("fill", function(d, i) { return fill(i); })
					.on("click", function(d) {window.location = d.link;})
					.attr("text-anchor", "middle")
					.attr("transform", function(d) { return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")"; })
					.text(function(d) { return d.text; });
			}
		});
	</script>
	