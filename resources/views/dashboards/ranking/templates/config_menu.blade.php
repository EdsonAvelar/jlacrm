<div class="context-overlay"></div> <!-- Overlay para bloquear a tela ao abrir a janela de configurações -->

<div id="settings-window">

    <div class="close-btn">X</div>


    <div class="settings-tabs">
        <div class="settings-tab active-tab" data-content="info-gerais">Informações Gerais</div>
        <div class="settings-tab" data-content="premiacao">Premiações</div>
        <div class="settings-tab" data-content="producao">Produção</div>
        <div class="settings-tab" data-content="sons">Sons</div>
        <div class="settings-tab" data-content="aparencia">Aparência</div>
    </div>
    <div class="settings-content">
        <div id="info-gerais" class="content-section">
            <h4>Informações Gerais</h4>
            <p>Configurações principais sobre o time.</p>

            <div class="mb-6">
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                    <label for="inputEmail3" class="col-form-label">Mostrar Equipes
                        <span class="mdi mdi-information"></span>
                    </label> </span>

                <input class="toggle-event" type="checkbox" <?php $exibir=config("ranking_mostrar_equipe"); if
                    ($exibir!=null & $exibir=='true' ){ echo 'checked' ;} ?>
                data-config_info="ranking_mostrar_equipe" data-toggle="toggle"
                data-on="com equipe" data-off="sem equipe"
                data-onstyle="success"
                data-offstyle="danger">
            </div>

            <div class="mb-6">
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                    <label for="inputEmail3" class="col-form-label">Mostrar Vendas
                        <span class="mdi mdi-information"></span>
                    </label> </span>

                <input class="toggle-event" type="checkbox" <?php $exibir_vendas=config("ranking_mostrar_vendas"); if
                    ($exibir_vendas!=null & $exibir_vendas=='true' ){ echo 'checked' ;} ?>
                data-config_info="ranking_mostrar_vendas" data-toggle="toggle"
                data-on="Com Vendas Totais" data-off="Sem Venda Totais"
                data-onstyle="success"
                data-offstyle="danger">
            </div>

            <div class="mb-6">
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                    <label for="inputEmail3" class="col-form-label">Carrossel
                        <span class="mdi mdi-information"></span>
                    </label> </span>

                <?php
                    $ranking_carrossel_timer = config('ranking_carrossel_timer');
                    if ($ranking_carrossel_timer)
                ?>

                <select name="update-interval" id="update-interval" onchange="saveConfigTimer()">
                    <option value="10000" <?=$ranking_carrossel_timer==10000 ? 'selected' : '' ?>>10 seg</option>
                    <option value="30000" <?=$ranking_carrossel_timer==30000 ? 'selected' : '' ?>>30 seg</option>
                    <option value="60000" <?=$ranking_carrossel_timer==60000 ? 'selected' : '' ?>>60 seg</option>
                    <option value="120000" <?=$ranking_carrossel_timer==120000 ? 'selected' : '' ?>>2 min</option>
                    <option value="600000" <?=$ranking_carrossel_timer==600000 ? 'selected' : '' ?>>10 min</option>
                    <option value="1800000" <?=$ranking_carrossel_timer==1800000 ? 'selected' : '' ?>>30 min</option>
                </select>


                {{-- <input class="toggle-event" type="checkbox" <?php $exibir_vendas=config("ranking_carrossel"); if
                    ($exibir_vendas!=null & $exibir_vendas=='true' ){ echo 'checked' ;} ?>
                data-config_info="ranking_carrossel" data-toggle="toggle"
                data-on="Ligado" data-off="Desligado"
                data-onstyle="success"
                data-offstyle="danger"> --}}
            </div>

        </div>
        <div id="premiacao" class="content-section hidden">
            <h4>Premiações</h4>
            <p>Defina as premiação de cada posição.</p>

            <div class="premiacao-item">
                <div class="premiacao-icon">

                    <img src="{{asset('images/ranking/'.$tema.'/icon-primeiro.png')}}" alt="Gold Trophy">
                </div>
                <div class="premiacao-1-img">
                    <a href="#" onclick="image_save('','/premiacao_1.png')" class="text-muted font-14">
                        <img src="{{ url('') }}/images/ranking/user/premiacao_1.png?{{ \Carbon\Carbon::now()->timestamp }}"
                            class="avatar-lx img-thumbnail" alt="profile-image">
                    </a>
                </div>

                <div class="premiacao-info">
                    <input type="text" value="{{config('ranking_premiacao_1')}}" id="ranking_premiacao_1" />
                </div>
                <div class="premiacao-visualizar" data-id="premiacao_1">
                    <?php 
                                            if (config('ranking_visivel_premiacao_1') == "false"){
                                                echo '<i class="fas fa-eye-slash"></i>';
                                            }else {
                                                echo '<i class="fas fa-eye"></i>';
                                            }
                                            
                                            ?>
                </div>
            </div>
            <div class="premiacao-item">

                <div class="premiacao-icon">
                    <img src="{{asset('images/ranking/'.$tema.'/icon-segundo.png')}}" alt="Silver Trophy">
                </div>

                <div class="premiacao-1-img">
                    <a href="#" onclick="image_save('','/premiacao_2.png')" class="text-muted font-14">
                        <img src="{{ url('') }}/images/ranking/user/premiacao_2.png?{{ \Carbon\Carbon::now()->timestamp }}"
                            class="avatar-lx img-thumbnail" alt="profile-image">
                    </a>
                </div>

                <div class="premiacao-info">
                    <input type="text" value="{{config('ranking_premiacao_2')}}" id="ranking_premiacao_2" />
                </div>
                <div class="premiacao-visualizar" data-id="premiacao_2">
                    <?php 
                            if (config('ranking_visivel_premiacao_2') == "false"){
                                echo '<i class="fas fa-eye-slash"></i>';
                            }else {
                                echo '<i class="fas fa-eye"></i>';
                            }
                            
                            ?>
                </div>
            </div>
            <div class="premiacao-item">
                <div class="premiacao-icon">
                    <img src="{{asset('images/ranking/'.$tema.'/icon-terceiro.png')}}" alt="Bronze Trophy">
                </div>

                <div class="premiacao-1-img">
                    <a href="#" onclick="image_save('','/premiacao_3.png')" class="text-muted font-14">
                        <img src="{{ url('') }}/images/ranking/user/premiacao_3.png?{{ \Carbon\Carbon::now()->timestamp }}"
                            class="avatar-lx img-thumbnail" alt="profile-image">
                    </a>
                </div>
                <div class="premiacao-info">
                    <input type="text" value="{{config('ranking_premiacao_3')}}" id="ranking_premiacao_3" />
                </div>
                <div class="premiacao-visualizar" data-id="premiacao_3">

                    <?php 
                   if (config('ranking_visivel_premiacao_3') == "false"){
                        echo '<i class="fas fa-eye-slash"></i>';
                    }else {
                        echo '<i class="fas fa-eye"></i>';
                    }
                    
                    ?>

                </div>
            </div>
            {{-- <div class="premiacao-salvar">
                <button>Salvar</button>
            </div> --}}
        </div>
        <div id="producao" class="content-section hidden">
            <h4>Produção</h4>
            <p>Configurações de produção.</p>
            <h3>Em Breve</h3>
        </div>
        <div id="sons" class="content-section hidden">
            <h4>Sons</h4>
            <p>Configurações de sons.</p>
            <h3>Em Breve</h3>
        </div>
        <div id="aparencia" class="content-section hidden">
            <h4>Aparência</h4>
            <p>Configurações de aparência.</p>
            <h3>Em Breve</h3>

        </div>
    </div>
</div>

<script>
    function saveConfigTimer() {

        

        var config_info = "ranking_carrossel_timer";
        var config_value = document.getElementById("update-interval").value;

        console.log(config_info, config_value)
        save_config(config_info, config_value);
    }
</script>