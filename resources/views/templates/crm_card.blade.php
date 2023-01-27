<style>

</style>
<?php 
$styles="";
$compact=true;
if (app('request')->view_card == "compact"){
    $styles = "height: 6rem;overflow: hidden";
} 
?>
<div class="card mb-0 mt-1" id={{$negocio_id}} style="{{$styles}}">
    <div class="card-body p-3">
        <small class="float-end text-muted">{{$created_at}}</small>
        <?php 
        
        if ($last_update < 2){
            echo "<span class=\"badge bg-success\">Novo</span>";
        }elseif ($last_update < 5) {
            echo "<span class=\"badge bg-warning\">Atenção</span>";
        }else {
            echo "<span class=\"badge bg-danger\">Urgente</span>";
        }

        ?>

        <h5 class="mt-1 mb-1">
            <a href="#" data-bs-toggle="modal" data-bs-target="#task-detail-modal" class="text-body"><?php 
            if ($compact == true) {
            echo mb_strimwidth($titulo,0,30);
        }else{
            echo $titulo;
        }
        ?> </a>
        </h5>

        <p class="mb-0" style="padding: 2 px">
            <span class="pe-2 text-nowrap mb-0 d-inline-block">
                <i class="mdi mdi-briefcase-outline text-muted"></i>
                {{$tipo}}
            </span>
            <span class="text-nowrap mb-0 d-inline-block">
                <i class="mdi mdi-cash text-muted"></i>
                <b>R$ {{ number_format( (float)$valor,2)}}</b>
            </span>
        </p>

        <div class="dropdown float-end">
            <a href="#" class="dropdown-toggle text-muted arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-dots-vertical font-18"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a href="{{route('negocio_edit', array('id' => $negocio_id ) )}}" class="dropdown-item"><i
                        class="mdi mdi-pencil me-1"></i>Editar</a>
                <!-- item-->
                <a href="#" class="dropdown-item ganhou_button" data-id="{{$negocio_id}}"><i class="dripicons-thumbs-up"></i><span
                        class="text-success"> Ganhou</span></a>
                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item"><i class="dripicons-thumbs-down"></i><span
                        class="text-danger"> Perdeu</span></a>
            </div>
        </div>

        <p class="mb-0">
            <img src="{{url('')}}/images/users/avatar-2.jpg" alt="user-img" class="avatar-xs rounded-circle me-1">
            <span class="align-middle">{{ $leadname }}</span>
        </p>
    </div> <!-- end card-body -->
</div>
<!-- Task Item End -->

