      <table class="table table-responsive" style="--bs-table-bg: transparent;">
          <tr>
              <th>Category</th>
              <th>Title</th>
              <th>Description</th>
              <th>Image</th>
              <th>Answer</th>
              <th>action</th>
          </tr>
          @forelse ($questions as $question)
              <tr>
                  @php
                      $category = App\Models\Category::where('id', $question->category_id)->first();
                  @endphp
                  <td>{{ $category->category_name }}</td>
                  <td>{{ $question->title }}</td>
                  <td>{{ $question->description }}</td>
                  <td><img src="{{ asset('questions12/images') . '/' . $question->image }}"
                          style="width: 100px;height:100px">
                  </td>
                  <td>
                      @foreach ($question->answers as $answers)
                          @if ($answers->correct == '1')
                              <p>{{ $answers->answer }}</p>
                          @endif
                      @endforeach
                  </td>
                  <td>
                      <form action="{{ route('delete_question') }}" method="post">
                          @csrf
                          <input type="hidden" name="question_id" value="{{ $question->id }}">
                          <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                              data-bs-target="#edit_question_modal{{ $question->id }}">Edit </button>
                          <button type="submit" class="btn btn-danger">Delete </button>
                      </form>
                  </td>
              </tr>


          @empty
          @endforelse
      </table>
      {{ $questions->links() }}

      @foreach ($questions as $question)
          <div class="modal fade" id="edit_question_modal{{ $question->id }}" tabindex="-1"
              aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Alter Questions</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <form method="POST" enctype="multipart/form-data"
                              action="{{ route('edit_submit_question') }}">
                              <input type="hidden" name="question_id" value="{{ $question->id }}">
                              @csrf
                              <div class="row mb-3">
                                  <label for="selectcategory" class="col-sm-3 col-form-label">Change Category</label>
                                  <div class="col-sm-9">
                                      <select name="category_id" class="form-control-sm">
                                          <option selected>--Please select=-</option>
                                          @foreach ($categories as $category)
                                              @if ($category->id == $question->category_id)
                                                  <option value="{{ $category->id }}" selected>
                                                      {{ $category->category_name }}
                                                  </option>
                                              @else
                                                  <option value="{{ $category->id }}">{{ $category->category_name }}
                                                  </option>
                                              @endif
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                              <div class="row mb-3">
                                  <label for="inputquestiontitle3" class="col-sm-3 col-form-label">Change
                                      Title</label>
                                  <div class="col-sm-9">
                                      <input type="text" name="title" class="form-control" id="inputquestiontitle3"
                                          value="{{ $question->title }}" />
                                  </div>
                              </div>
                              <div class="row mb-3">
                                  <label for="inputimage3" class="col-sm-3 col-form-label">Change Image:</label>
                                  <div class="col-sm-9">
                                      <img src="{{ asset('questions12/images') . '/' . $question->image }}"
                                          class="img-thumbnail" style="width: 100px;height:100px">
                                      <input type="file" accept="image/*" name="image" class="form-control"
                                          id="inputimage3" />
                                  </div>
                              </div>
                              <div class="row mb-3">
                                  <label for="inputDescription3" class="col-sm-3 col-form-label"> Change
                                      Description</label>
                                  <div class="col-sm-9">
                                      <input type="text" name="description" class="form-control"
                                          id="inputDescription3" value="{{ $question->description }}">
                                  </div>
                              </div>
                              <fieldset class="row mb-3">

                                  <legend class="col-form-label col-sm-3 pt-0">Answers</legend>
                                  <div class="col-sm-9">
                                      @php
                                          $i = 1;
                                      @endphp
                                      @forelse ($question->answers as $answer)
                                          @if ($answer->question_id == $question->id)
                                              @if ($answer->correct == '1')
                                                  <div class="form-check">
                                                      <input type="text" placeholder="answer []"
                                                          name="answer[{{ $i }}]"
                                                          value=" {{ $answer->answer }}">
                                                      <input class="form-check-input" type="radio" name="answers"
                                                          checked value="{{ $i }}">
                                                  </div>
                                              @else
                                                  <div class="form-check">
                                                      <input type="text" placeholder="answer"
                                                          name="answer[{{ $i }}]"
                                                          value=" {{ $answer->answer }}">
                                                      <input class="form-check-input" type="radio" name="answers"
                                                          value="{{ $i }}">
                                                  </div>
                                              @endif
                                          @endif
                                          @php
                                              ++$i;
                                          @endphp
                                      @empty
                                          <fieldset class="row mb-3">
                                              <div class="col-sm-10">
                                                  <div class="form-check">
                                                      <input type="text" placeholder="answer 1" name="answer[1]">
                                                      <input class="form-check-input" type="radio" name="answers"
                                                          value="1">
                                                  </div>
                                                  <div class="form-check">
                                                      <input type="text" placeholder="answer 2" name="answer[2]">
                                                      <input class="form-check-input" type="radio" name="answers"
                                                          value="2">

                                                  </div>
                                                  <div class="form-check">
                                                      <input type="text" placeholder="answer 3" name="answer[3]">
                                                      <input class="form-check-input" type="radio" name="answers"
                                                          value="3">

                                                  </div>
                                                  <div class="form-check">
                                                      <input type="text" placeholder="answer 4" name="answer[4]">
                                                      <input class="form-check-input" type="radio" name="answers"
                                                          value="4">

                                                  </div>
                                              </div>
                                          </fieldset>
                                      @endforelse
                                  </div>
                              </fieldset>
                              <input type="submit" class="btn btn-primary" value="Save Changes">
                          </form>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                  </div>
              </div>
          </div>
      @endforeach
