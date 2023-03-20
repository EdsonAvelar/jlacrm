<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script> 
<script src="https://jsuites.net/v4/jsuites.js"></script>

<script >

	
// JavaScript Document

var_zap = 11954855581
var url_montada = ""

var obj = {
    'imovel' : {
        'quarterly' : '1.41',
        'monthly' : '1.28',
        'weekly' : '1.2'
    },
    'veiculo' : {
        'quarterly' : '1.38',
        'monthly' : '1.25',
        'weekly' : '1.8'
    },
    'maquinario' : {

        'quarterly' : '1.35',
        'monthly' : '1.225',
        'weekly' : '1.15'
    }
};

$(document).ready(function() {

    $("#total").val("10000");

    $("#slider_amirol").slider({
        range: "min",
        animate: true,

        min: 0,
        max: 99,
        step: 1,
        slide: 
            function(event, ui) 
            {
                update(1,ui.value); //changed
                calcualtePrice(ui.value);
            }
    });

    $('.month').on('click',function(event) {
        var id = $(this).attr('id');

        $('.month').removeClass('selected-month');
        $(this).addClass('selected-month');
        $(".month").removeClass("active-month");
        
        $(".month").removeClass("active");
        $(this).addClass("active");
        
        $(this).addClass("active-month");

        $('#tipo_credito').val(id);

        update();
        calcualtePrice()
    });

    $('.term').on('click',function(event) {
        var id = $(this).attr('id');

        $('.term').removeClass('selected-term');
        $(this).addClass('selected-term');
        $(".term").removeClass("active-term");
        $(this).addClass("active-term");


        $(".term").removeClass("active");
        $(this).addClass("active");
        


        $('#simular_por').val(id);

        update();
        calcualtePrice()
        
    });

    update();
    calcualtePrice();
});

function kFormatter(num) {
    
    
    if (Math.abs(num) > 999999) {
        return Math.sign(num)*((Math.abs(num)/1000000).toFixed(2)) + 'M'
    }else if (Math.abs(num) > 999) {
    
        return Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'k'
    }else{
        return Math.sign(num)*Math.abs(num)
    }
   
}

function gerarRange(min, max,value=true){
    var amount = {};
    var famount = {}
    var inc = (max - min)/100

    for (var i = 0; i < 100; i++) {
       

            var tmp_amount = (min + (inc*i)).toFixed()
            amount[i] = tmp_amount
            famount[i] = kFormatter(tmp_amount)
     
    }
    
    amount[i-1] = max
    famount[i-1] = kFormatter(max)

 return {amount,famount}
}



function getCredit(tipo_credito, simular_por){

    var res = null;
    var min = 0;
    var max = 0;

    if (tipo_credito == "imovel" & simular_por == "credito") {
        min = 30000
        max = 1000000
        
    }else if ( tipo_credito == "imovel" & simular_por == "parcela") {
        min = 100
        max = 5000
    }else if ( tipo_credito == "veiculo" & simular_por == "credito") {
        min = 10000
        max = 200000

    }else if ( tipo_credito == "veiculo" & simular_por == "parcela") {
        min = 100
        max = 5000
    }else if ( tipo_credito == "maquinario" & simular_por == "credito") {
        min = 10000
        max = 1000000
    }else if ( tipo_credito == "maquinario" & simular_por == "parcela") {
        min = 100
        max = 10000
    }


    

    res  = gerarRange(min,max);

    

    p = res['amount']
    t = res['famount']

    var min = jSuites.mask.run(min, '(#.##0,00');
    var max = jSuites.mask.run(max, '(#.##0,00');
    $('#credit-min').html('<div id="credit-min" class="min" data-mask=\'#.##0,00\'>R$ '+min+'</div>') 
    $('#credit-max').html('<div id="credit-min" class="min" data-mask=\'#.##0,00\'>R$ '+max+'</div>') 

    //console.log("aki",p,t)
    return {p, t}
}

       
function update(slider, val) {

    $("#slider_amirol").slider('value',0);

    if(undefined === val) val = 0;

    var tipo = $('#tipo_credito').val();
    var simular = $('#simular_por').val();

    var p = getCredit(tipo,simular)['p']
    
    //console.log(p)

    var amount = p[val];

    $('#sliderVal').val(amount);

    //$('#slider_amirol a').html('<label><span class="glyphicon glyphicon-chevron-left"></span> '+amount+' <span class="glyphicon glyphicon-chevron-right"></span></label>');

    var amount = jSuites.mask.run(amount, '(#.##0,00');

     $('#amount').html('<div id="amount" class="big">'+amount+ '</div>') 
   
}

function calcualtePrice(val){
    
    if(undefined === val)
        val = $('#sliderVal').val();

  

    var tipo = $('#tipo_credito').val();
    var simular = $('#simular_por').val();

    var t = getCredit(tipo,simular)['t']

      if (simular == "parcela"){
        $('#valorcp').html('<span> da Parcela: </span>')
        $('#tipocp').html('Parcela')
        

    }else {
        $('#valorcp').html('<span> do Crédito: </span>')
        $('#tipocp').html('Crédito')
    }
}


function goToURL() {
    location.href = 'https://api.whatsapp.com/send?phone=5591981271209&text=ok';

  }

  $('#botao_simular').click(function(){
    // document.location = "https://api.whatsapp.com/send?phone=55"+var_zap+"&text="+url_montada;
   
    var tipo = $('#tipo_credito').val();
    var simular = $('#simular_por').val();

    var valor = jSuites.mask.run($('#sliderVal').val(), '(#.##0,00');

    url_montada = "Gostaria de uma simulação de um "+tipo+" no valor de R$ "+valor+" de "+simular;

    var urlfinal = window.location.protocol + "//" +"api.whatsapp.com/send?phone=55"+var_zap+"&text="+url_montada;
    //console.log(urlfinal)

    document.location = urlfinal

    
  })

</script>
