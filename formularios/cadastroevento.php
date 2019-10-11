<form action="#" method="POST" id="formCadastroEvento">
    <div class="form-inline">
        <label for="Descricao"><strong>Descrição</strong></label>
        <input type="text" name="descricao" class="form-control" style="width: 50%;">
        <label for="cargahoraria"><strong>Carga Horária</strong></label>
        <input type="time" name="cargahoraria" class="form-control" style="width: 10%;">
    </div>
    <div class="form-inline itensCadastroEvento">
        <label for="data_inicio"><strong>Inicio</strong></label>
        <input type="date" name="data_inicio" class="form-control">
        <label for="data_fim"><strong>Fim</strong></label>
        <input type="date" name="data_fim" class="form-control">
    </div>
    <div class="form-inline itensCadastroEvento" id="tipoEvento">
        <label for="tipo"><strong>Tipo:</strong></label>
        <input type="radio" name="tipo" class="form-control" value="extensao" onclick="CriaElementoTipoEvento()">Extenção
        <input type="radio" name="tipo" class="form-control" style="margin-left: 10px;" value="pesquisa" onclick="CriaElementoTipoEvento()">Pesquisa
        <div id="tipoEventoEnquadramento" class="form-inline">
            
        </div>
    </div>

    <div class="form-inline itensCadastroEvento" id="solicitacaoDiv">
        
    </div>
    <div class="form-inline itensCadastroEvento" id="divSIGAMAP">
        
    </div>
    <div class="form-inline itensCadastroEvento">
        <label for="colegiadocurso"><strong>Informado ao colegiado do curso:</strong></label>
        <input type="radio" name="colegiado" value="sim" class="form-control" onclick="CriaColegiadoCurso()">Sim
        <input type="radio" name="colegiado" value="nao" class="form-control" style="margin-left: 10px;" onclick="CriaColegiadoCurso()">Não
        <div class="form-inline" id="divColegiadoCurso">
           
        </div>
        
    </div>

    <div class="form-inline itensCadastroEvento">
        <label for="ocorrencias"><strong>Outras Ocorrências:</strong></label>
        <input type="text" name="ocorrencias" class="form-control" placeholder="Outras Ocorrências" style="width: 100%;">
    </div>
    <div class="form-inline itensCadastroEvento">
        <label for="Curso"><strong>Curso:</strong></label>
        <select name="cursos" class="form-control">
            <option value=""></option>
            <option value="agronomia">Agronomia</option>
            <option value="Ciências Biológicas">Ciências Biológicas</option>
            <option value="Direito">Direito</option>
            <option value="Educação Física">Educação Física</option>
            <option value="Engenharia da Computação">Engenharia da Computação</option>
            <option value="Engenharia Elétrica">Engenharia Elétrica</option>
            <option value="Pedagogia">Pedagogia</option>
            <option value="Psicologia">Psicologia</option>
            <option value="Química">Química</option>
            <option value="Sistemas de Informação">Sistemas de Informação</option>
            <option value="Tecnologia em Agronegócio">Tecnologia em Agronegócio</option>
            <option value="Tecnologia em Gestão Ambiental">Tecnologia em Gestão Ambiental</option>
        </select>
    </div>
    <small style="color: red;">Caso não pertença a nenhum curso deixar em branco</small>
    <div>
        <input type="submit" name="cadastrarEvento" value="Cadastrar" class="btn btn-primary" style="margin: auto; box-shadow: none !important; border-color: #3c6178 !important; background-color: #3c6178 !important; display: flex; position: relative; justify-content: center; margin-top: 20px;">
    </div>
</form>