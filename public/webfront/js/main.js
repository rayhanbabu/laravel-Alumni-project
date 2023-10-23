(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').addClass('shadow-sm').css('top', '0px');
        } else {
            $('.sticky-top').removeClass('shadow-sm').css('top', '-100px');
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000
    });


    // Skills
    $('.skill').waypoint(function () {
        $('.progress .progress-bar').each(function () {
            $(this).css("width", $(this).attr("aria-valuenow") + '%');
        });
    }, {offset: '80%'});


    // Project carousel
    $(".project-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        loop: true,
        nav: false,
        dots: true,
        dotsData: true,
        responsive: {
            0:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        loop: true,
        center: true,
        dots: false,
        nav: true,
        navText : [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });


    // edit employee ajax request
    $(document).on('click', '.viewmember', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        //alert(id);
        $.ajax({
          type:'GET',
          url:'/web/viewmember/edit',
          data: {
            id: id,
          },
          success: function(response){
             console.log(response);
             $("#viewEmployeeModal").modal('show');
            $("#edit_serial").text(response.data.serial);
            $("#edit_name").text(response.data.name);
            $("#edit_workplace").text(response.data.workplace);
            $("#edit_current_address").text(response.data.current_address);
            $("#edit_permanent_address").text(response.data.permanent_address);
            $("#edit_blood").text(response.data.blood);
            if(response.data.phone_status=='show'){
                $("#edit_phone").text(response.data.phone);
            }else{
                $("#edit_phone").text(''); 
            }

            if(response.data.email_status=='show'){
                $("#edit_email").text(response.data.email);
            }else{
                $("#edit_email").text(''); 
            }

            if(response.data.blood_status=='show'){
                $("#edit_blood").text(response.data.blood);
            }else{
                $("#edit_blood").text(''); 
            }
           
            
            $("#edit_category").text(response.data.category);
            $("#edit_blood_status").text(response.data.blood_status);
            $("#edit_phone_status").text(response.data.phone_status);
            $("#edit_email_status").text(response.data.email_status);
            $("#avatar").html(
              `<img src="/uploads/admin/${response.data.image}" width="100" class="img-fluid border rounded-circle w-50 p-2 mb-4">`);
            $("#edit_id").val(response.data.id);
          }
        });
      });

    
})(jQuery);

