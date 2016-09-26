var spinner =   "<div class='spinner'>"+
                  "<div class='rect1'></div>"+
                  "<div class='rect2'></div>"+
                  "<div class='rect3'></div>"+
                  "<div class='rect4'></div>"+
                  "<div class='rect5'></div>"+
                "</div>";

$('.timepicker').timepicker({
    minuteStep: 30,
    showInputs: false,
    disableFocus: true
});

$('.clockface').clockface({
    format: 'HH:mm',
    trigger: 'manual'
});

$('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    todayBtn: true,
    language: "es",
    todayHighlight: true,
    autoclose: true,
    orientation: "auto",
});

$('#wizard').stepy({
    finishButton: true, 
    titleClick: false, 
    block: true, 
    validate: true,
    transition: 'fade'
});

//Add Wizard Compability - see docs
$('.stepy-navigator').wrapInner('<div class="pull-right"></div>');

//Make Validation Compability - see docs
$('#wizard').validate({
    errorClass: "help-block",
    validClass: "help-block",
    highlight: function(element, errorClass,validClass) {
       $(element).closest('.form-group').addClass("has-error");
    },
    unhighlight: function(element, errorClass,validClass) {
        $(element).closest('.form-group').removeClass("has-error");
    }
 });

$('body').delegate('.load-in-progress','click', function(e){
    e.preventDefault();

    var url = $(this).attr('href');
    var content = $(this).data('id');
    $(content).html(spinner);
    
    $.ajax({
        method: 'GET',
        url: url,
        success: function(data) {
            $(content).fadeIn().html(data);
        },
        error: function() {
            console.log('Error!');
        }
    });
});

$('body').delegate('.load-in','click', function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    var content = $(this).data('id');
    $(content).html(spinner);
    
    $.ajax({
        method: 'GET',
        url: url,
        success: function(data) {
            $(content).html(data);
        },
        error: function() {
            console.log('Error!');
        }
    });
});

$('body').delegate('.element-hide','click', function(e){
    var element = $(this).data('id');
    $(element).hide('slow');
});

$('body').delegate('.element-show','click', function(e){
    var element = $(this).data('id');
    $(element).show('slow');
});

