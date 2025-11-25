 <script>
     function view_questions(category_id) {
         $.ajax({
             url: "{{ route('view_questions_ajax') }}",
             method: "post",
             data: {
                 category_id: category_id,
                 '_token': '{{ csrf_token() }}'
             },
             dataType: 'json',
             success: function(response) {
                 $(".questions").html('');
                 console.log(response);
                 $.each(response, function(index, data) {
                     $(".questions").append(`
                            <div class="form-check">
                            <input class="form-check-input" name="questions[]" type="checkbox"
                                id="inputquestions${data.id}" value="${data.id}">
                            <label class="form-check-label" for="gridCheck">
                                ${data.title}
                            </label>
                        </div>
                        `);
                 });
             }
         })
     }

     function null_questions() {
         $(".questions").html('');
     }
 </script>
