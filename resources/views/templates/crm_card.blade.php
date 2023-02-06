<style>

</style>
<?php 
$styles="height: 11rem;";
$compact=false;
$mb="mt-2 mb-2";
if (app('request')->view_card == "compact"){
    $styles = "height: 7rem;";
    $compact=true;
    $mb="mt-1 mb-1";
} 
?>
<div class="card mb-0 mt-1" id={{$negocio_id}} style="{{$styles}}">
    <div class="card-body p-3">
    
    <div class="dropdown float-end">
            <a href="#" class="dropdown-toggle text-muted arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-dots-vertical font-18"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a href="{{route('negocio_edit', array('id' => $negocio_id ) )}}" class="dropdown-item"><i
                        class="mdi mdi-pencil me-1"></i>Editar</a>
                <!-- item-->
                @if ( $negocio->status == "ATIVO" )
                    <a href="#" class="dropdown-item ganhou_button" data-id="{{$negocio_id}}"><i class="dripicons-thumbs-up"></i><span
                        class="text-success"> Ganhou</span></a>

                   <!-- item-->
                   <a href="javascript:void(0);" class="dropdown-item perdeu_button" data-id="{{$negocio_id}}"><i class="dripicons-thumbs-down"></i><span
                        class="text-danger"> Perdeu</span></a>
                @endif
                
                
             
            </div>
        </div>

    <a class="float-end text-muted" href="tel:{{$telefone}}">{{$telefone}}</a>

        <?php 
        
        if ( $negocio->status == "ATIVO" ) {
            if ($last_update < 2){
                echo "<span class=\"badge bg-info float-begin\">NOVO</span>";
            }elseif ($last_update < 5) {
                echo "<span class=\"badge bg-warning float-begin\">ATENÇÃO</span>";
            }else {
                echo "<span class=\"badge bg-danger float-begin\">URGENTE</span>";
            }
        }elseif ($negocio->status == "PERDIDO"){
            echo "<span class=\"badge bg-danger float-begin\">PERDIDO</span>";
        }elseif ($negocio->status == "VENDIDO"){
            echo "<span class=\"badge bg-success float-begin\">VENDIDO</span>";
        }else {
            echo "<span class=\"badge bg-primary float-begin\">".$negocio->status."</span>";
        }

        ?>
        

        <h5 class="{{$mb}}">
            <a href="#" data-bs-toggle="modal" data-bs-target="#task-detail-modal" class="text-body"><?php 
            if ($compact == true) {
            echo mb_strimwidth($titulo,0,30);
        }else{
            echo $titulo;
        }
        ?> </a>
        </h5>

        <p class="{{$mb}}" style="padding: 2 px">
            <span class="pe-2 text-nowrap mb-0 d-inline-block">
                <i class="mdi mdi-briefcase-outline text-muted"></i>
                {{$tipo}}
            </span>
            <span class="text-nowrap mb-0 d-inline-block">
                <i class="mdi mdi-cash text-muted"></i>
                <b>R$ {{ number_format( (float)$valor,2)}}</b>
            </span>
        </p>

       
        @if($compact != true)
        <p class="{{$mb}}">
            
            @if (!is_null($negocio->user))
            <img src="{{url('')}}/images/users/user_{{$negocio->user->id}}/{{$negocio->user->avatar}}" alt="user-img" class="avatar-xs rounded-circle me-1">
            @else
            <img src="{{url('')}}/images/users/avatars/user-padrao.png" alt="user-img" class="avatar-xs rounded-circle me-1">
            @endif
            
            <span class="align-middle">{{ $leadname }}</span>
        </p>
        @endif

    </div> <!-- end card-body -->
</div>
<!-- Task Item End -->
