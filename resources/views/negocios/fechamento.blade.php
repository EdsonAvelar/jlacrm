@extends('main')
<?php 

use App\Enums\UserStatus;
use App\Models\User;
?>

@section('main_content')

<style>

    .mb-3 {
        margin-bottom: 0.25rem !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <!-- Profile -->
            <div class="card bg-secondary">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-lg">
                                        <img src="{{url('')}}/images/users/avatars/user-padrao.png" alt=""
                                            class="rounded-circle img-thumbnail">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div>
                                        <p class="font-20 text-white-50">FICHA DE CADASTRAMENTO DE VENDA</p>
                                        <p class="font-20 text-white-50">Cliente: {{$negocio->lead->nome}}</p>
                               
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        
                    </div> <!-- end row -->

                </div> <!-- end card-body/ profile-user-box-->
            </div><!--end profile/ card -->
        </div> <!-- end col-->
    </div>

    <div class="row">
        
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="tab-pane" id="administrativo">
                        <form method="POST" action="{{route('negocio_update') }}">
                            @csrf
                            
                            <h5 class="mb-3 text-uppercase bg-warning p-2"><i
                                class="mdi mdi-office-building me-1"></i> Informações Pessoais Consorciado</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">NOME COMPLETO</label>
                                        <input type="text" class="form-control" id="firstname" value="" name="nome">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">DATA DE NASCIMENTO</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">NOME DO PAI</label>
                                        <input type="text" class="form-control" id="firstname" value="" name="nome">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">NOME DA MÃE</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">CPF</label>
                                        <input type="text" class="form-control" id="firstname" value="" name="nome">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">RG</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">ORGÃO EXPEDITOR</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">DATA DE EXPEDIÇÃO</label>
                                        <input type="text" class="form-control" id="firstname" value="" name="nome">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">NACIONALIDADE</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">NATURALIDADE</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">ESTADO CIVIL</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">GÊNERO</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">FORMAÇÃO</label>
                                        <input type="text" class="form-control" id="firstname" value="" name="nome">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">PROFISSÃO/CARGO</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">RENDA LIQUIDA MENSAL</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>
                                
                            </div>


                            

                            <h5 class="mb-3 text-uppercase bg-warning p-2"><i
                                class="mdi mdi-office-building me-1"></i> INFORMAÇÕES PESSOAIS DO CÔNJUDE</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">NOME COMPLETO</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">DATA DE NASCIMENTO</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">CPF</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">RG</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>
    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">ORGÃO EXPEDITOR</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">DATA DE EXPEDIÇÃO</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">NACIONALIDADE</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">NATURALIDADE</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>
                             
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">GÊNERO</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>
                                </div>
 
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">FORMAÇÃO</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">PROFISSÃO/CARGO</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">RENDA LIQUIDA MENSAL</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>
                                    
                                </div>


                            <h5 class="mb-3 text-uppercase bg-warning p-2"><i
                                class="mdi mdi-office-building me-1"></i> DADOS DO PLANO CONTRATADO</h5>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">ESPÉCIE</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">MARCA</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">MODELO</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">CÓDIGO DO BEM</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                </div>

                              


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">PREÇO DO BEM</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">DURAÇÃO DO GRUPO</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">DURAÇÃO DO PLANO</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">TIPO DO PLANO</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">PLANO LEVE (LIGHT)</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">SEGURO PRESTAMISTA</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">GRUPO EM FORMAÇÃO</label>
                                            <select class="form-select" required>
                                                <option selected value="">Selecione</option>
                                                <option value="sim">SIM</option>
                                                <option value="nao">NÃO</option>
                                                
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">GRUPO EM ANDAMENTO</label>
                                            <select class="form-select"  required>
                                                <option selected value="">Selecione</option>
                                                <option value="sim">SIM</option>
                                                <option value="nao">NÃO</option>
                                                
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Nº ASSEMBLÉIA DA ADESÃO</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">DATA DA ASSEMBLÉIA</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                        </div>
                                    </div>
                                </div>
                            

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">PAGAMENTO INCORPORADO</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">PAGAMENTO ATÉ A CONTEMPLAÇÃO</label>
                                            <input type="text" class="form-control" id="firstname" value="" name="nome">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">TABELA</label>
                                            <select class="form-select" aria-label="Default select example" required>
                                                <option selected value="">Selecione</option>
                                                <option value="cima">DE CIMA</option>
                                                <option value="baixo">DE BAIXO</option>
                                                
                                              </select>
                                        </div>
                                    </div>
                                </div>
                                    

                            <h5 class="mb-3 text-uppercase bg-warning p-2"><i
                                class="mdi mdi-office-building me-1"></i> FORMA DE PAGAMENTO INICIAL</h5>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">PARCELA</label>
                                        <input type="text" class="form-control" id="firstname" value="" name="nome">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">PARCELAS ANTECIPADAS</label>
                                        <input type="text" class="form-control" id="firstname" value="" name="nome">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">TOTAL ANTECIPADO</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">ADESÃO</label>
                                        <input type="text" class="form-control" id="firstname" value="" name="nome">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">PRIMEIRA PARCELA</label>
                                        <input type="text" class="form-control" id="firstname" value="" name="nome">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">TOTAL PAGO EM GERAL</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{$negocio->lead->email}}">
                                    </div>
                                </div>
                            </div>

                            </br>
                            <div class="row">
                                <label for="email" class="form-label"><strong>FORMA DE PAGAMENTO DO PLANO:</strong></label>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pagamento" id="rb_dinheiro" value="dinheiro">
                                        <label class="form-check-label" for="inlineRadio1">DINHEIRO</label>
                                      </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pagamento" id="inlineRadio2" value="debito">
                                        <label class="form-check-label" for="inlineRadio2">CARTÃO DÉBITO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pagamento" id="inlineRadio2" value="credito">
                                        <label class="form-check-label" for="inlineRadio2">CARTÃO CRÉDITO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pagamento" id="inlineRadio2" value="fgts">
                                        <label class="form-check-label" for="inlineRadio2">FGTS</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pagamento" id="inlineRadio2" value="boleto">
                                        <label class="form-check-label" for="inlineRadio2">BOLETO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pagamento" id="inlineRadio2" value="transferencia">
                                        <label class="form-check-label" for="inlineRadio2">TRANSFERÊNCIA/PIX</label>
                                    </div>
                                </div>
                            </div>
                        </br>


                            <h5 class="mb-3 text-uppercase bg-success p-2"><i
                                class="mdi mdi-office-building me-1"></i> CHECAGEM DO ADMINISTRATIVO</h5>

                            <div class="row">

                                <label for="email" class="form-label"><strong>:</strong></label>

                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="sc_doc_consorciado">
                                        <label class="form-label form-check-label" for="flexSwitchCheckDefault">DOCUMENTO CONSÓRCIADO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="sc_doc_conjugue">
                                        <label class="form-label form-check-label" for="flexSwitchCheckDefault">DOCUMENTO CÔNJUGUE</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="sc_pagamento">
                                        <label class="form-label form-check-label" for="flexSwitchCheckDefault">COMPROVANTE PAGAMENTO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="sc_endereco">
                                        <label class="form-label form-check-label" for="flexSwitchCheckDefault">COMPROVANTE ENDEREÇO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="sc_venda">
                                        <label class="form-label form-check-label" for="flexSwitchCheckDefault">COMPROVANTE VENDA</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="sc_self">
                                        <label class="form-label form-check-label" for="flexSwitchCheckDefault">SELF DECLARAÇÃO</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="sc_controle_qualidade">
                                        <label class="form-label form-check-label" for="flexSwitchCheckDefault">CONTROLE DE QUALIDADE</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="sc_video">
                                        <label class="form-label form-check-label" for="flexSwitchCheckDefault">VIDEO</label>
                                    </div>
                                </div>                                
                            </br>
                            </div>

                            <input name="id_negocio" value="{{app('request')->id}}" hidden >
                            <div class="text-end">
                                <button type="submit" class="btn btn-success mt-2"><i
                                        class="mdi mdi-content-save"></i> Salvar</button>
                            </div>
                        </form>
                    </div>
                    
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->

</div>
<!-- container -->



@endsection


@section('specific_scripts')

<script>
function atribuir($negocio_id, $user_id){
    console.log("Atribuir " + $negocio_id +"para"+ $user_id);
}
</script>
@endsection