@if (session()->has('flash_message'))
    <script>
        swal({
           title: "{{ session('flash_message.title') }}",
           text: "{{ session('flash_message.message') }}",
           type: "{{ session('flash_message.level') }}",
           timer: 2500,
           showConfirmButton: false,
           allowEscapeKey: true,
           allowOutsideClick: true
        },
           function() {
                location.reload(true);
           });
    </script>
@endif