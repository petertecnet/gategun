@csrf

<div class="row">

    <div class="col-md-8">

        Curso:
        <input type="text" name="nomedocurso" id="nomedocurso" value="{{ $cad->nomedocurso ?? old('nomedocurso') }}"
            class="form-control">
    </div>
    <div class="col-md-4">

        Quant. Max.:
        <input type="text" name="qntmax" id="qntmax" value="{{ $cad->qntmax ?? old('qntmax') }}" class="form-control">
    </div>
    <div class="col-md-12">
        <br>
        Descrição:
        <input type="text" name="descricao" id="descricao" value="{{ $cad->descricao ?? old('descricao') }}"
            class="form-control">
        <br>
    </div>
    <div class="col-md-4">

        Categoria:
        <input type="text" name="categoria" id="categoria" value="{{ $cad->categoria ?? old('categoria') }}"
            class="form-control">
    </div>
    <div class="col-md-4">

        Mensalidade:
        <input type="text" name="mensalidade" id="mensalidade" value="{{ $cad->mensalidade ?? old('mensalidade') }}"
            class="form-control">
    </div>
    <div class="col-md-4">

        Status:
        <select class="select2bs4" name="status" id="status" style="width: 100%;">
            <option {{ ($cad->status ?? old('status')) == 'Disponível' ? 'selected' : '' }} value="Disponível">
                Disponível
            </option>
            <option {{ ($cad->status ?? old('status')) == 'Indisponível' ? 'selected' : '' }} value="Indisponível">
                Indisponível</option>
        </select>
    </div>
</div>
<button type="subbmit" class="btn btn-primary addCompany">Salvar</button>