@template('layout/painel');


@section('meio')
	Olá, não esqueça de informar qual página você quer alterar!
	
	<p>
		<select id="selectPaginas">
			<?php foreach($arrPaginas as $objPagina) :  ?>
				<option <?php echo $objPagina === $objPagAtual ? 'selected' : ''; ?> value="<?php echo $objPagina['secty_cod_pag']; ?>"><?php echo $objPagina['secty_title_pag']; ?></value>
			<?php endforeach; ?>
		</select>
	</p>
	
	<p>
		<div id="ck_editor">
			<textarea class="ckeditor" name="ckeditor"><?php echo $objPagAtual != null ? $objPagAtual['secty_dsc_pag'] : 'Informe qual pagina deseja alterar'; ?></textarea>
		</div>

		<br>
		<input type="button" onclick="fnSalvarAlteracoes();" class="btn btn-primary" id="btEnviar" value="Salvar alterações">
	</p>


<script>
	$(document).ready(function()
	{
		fnCarregaPagina();
	});

	function fnCarregaPagina()
	{
		$("#selectPaginas").on('change', function(){
			var url = "{{url('/editar-paginas/')}}" + $(this).val();
			window.location.href= url;
		});
	}

	function fnSalvarAlteracoes()
	{
		var url = "{{url('/editar-paginas/')}}" + $("#selectPaginas").val() + "/1";
		
		$.ajax({
			url: url,
			method: 'POST',
			data: {conteudo: CKEDITOR.instances['ckeditor'].getData()},
			beforeSend: function(){
				$(this).attr('disabled');
			},
			success : function(response){
				alert('Salvo');
			},
			complete: function(){

			}
		});
	}
</script>

@stop