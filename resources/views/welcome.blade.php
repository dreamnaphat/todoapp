<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e48703cd74.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{url('css/app.css')}}">
    <meta charset="utf-8">
    <title>TODO APP</title>
  </head>
  <body style="background-image: url({{url('images/bg/background.jpg')}})">

    <div class="container pb-5">
      <div class="row justify-content-center">
        <div class="col-10">
          <div class="card mt-5 p-3">
            <h2>My TODO APP</h2>
            <div class="card-body">
              <div class="row">
                <form action="new-todo" method="post">
                  @csrf
                  <div class="input-group">
                    <input type="text" name="description" class="form-control" placeholder="TODO here" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2">Add</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-10">
          <div class="card mt-2">
            <div class="card-body">
              @if($todos->count() >= 1)
              <div class="container">
                @foreach($todos as $todo)
                <div class="row p-2">
                  <div class="col-7 ps-4">
                    {{$todo->description}}
                  </div>
                  <div class="col-2">
                    @if($todo->status == 0)
                    <i class="fas fa-circle text-secondary"></i>&nbsp;&nbsp;ยังไม่ได้ทำ
                    @elseif($todo->status == 1)
                    <i class="fas fa-circle text-primary"></i>&nbsp;&nbsp;กำลังทำ
                    @elseif($todo->status == 2)
                    <i class="fas fa-circle text-success"></i>&nbsp;&nbsp;ทำเสร็จแล้ว
                    @endif
                  </div>
                  <div class="col-2">
                    <span class="fw-light">{{$todo->updated_at}}</span>
                  </div>
                  <div class="col-1">
                    <a href="#"><i class="fas fa-edit" data-bs-toggle="modal" data-bs-target="#todoModal{{$todo->id}}"></i></a>
                    &nbsp;
                    <a href="#"><i class="fas fa-trash-alt text-danger" data-bs-toggle="modal" data-bs-target="#todoDelModal{{$todo->id}}"></i></a>
                    <!-- edit modal  -->
                    <div class="modal fade" id="todoModal{{$todo->id}}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูล</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">

                            <textarea name="description" class="form-control border-0 text-secondary" disabled style="resize:none;">{{$todo->description}}</textarea>
                            <div class="pt-2">
                              <span class=""> เลือกความคืบหน้าการดำเนินงาน </span>
                            </div>
                            <form class="mt-2" action="update" method="post">
                              @csrf
                              <input type="text" name="todo_id" value="{{$todo->id}}" hidden>
                              <input type="radio" class="btn-check" id="pending{{$todo->id}}" name="status" value="0" autocomplete="off">
                              <label class="btn btn-outline-secondary" for="pending{{$todo->id}}">ยังไม่ได้ทำ</label>

                              <input type="radio" class="btn-check" id="inprogress{{$todo->id}}" name="status" value="1" autocomplete="off">
                              <label class="btn btn-outline-primary" for="inprogress{{$todo->id}}">กำลังทำ</label>

                              <input type="radio" class="btn-check" id="success{{$todo->id}}" name="status" value="2" autocomplete="off">
                              <label class="btn btn-outline-success" for="success{{$todo->id}}">ทำเสร็จแล้ว</label>


                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-success">บันทึก</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end edit modal -->

                    <!-- delete modal -->
                    <div class="modal fade" id="todoDelModal{{$todo->id}}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลบ ?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            หากลบแล้วข้อมูลจะหายไปทันที
                            <form class="" action="delete" method="post">
                              @csrf
                              <input type="hidden" name="todo_id" value="{{$todo->id}}">

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-danger">ลบ</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end delete modal -->
                  </div>
                </div>
                @endforeach

              </div>
              <hr>
              <div class="row">
                <div class="col align-self-start">
                  <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#todoDelAllModal">ลบรายการทั้งหมด <i class="fas fa-trash"></i></a>
                </div>
                <div class="col align-self-center">

                </div>
                <div class="col align-self-end text-end">
                  {{ $todos->links() }}
                </div>
              </div>

              <div class="modal fade" id="todoDelAllModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลบ ?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      หากลบแล้วข้อมูลทั้งหมดจะหายไปทันที
                      <form class="" action="delete-all" method="post">
                        @csrf
                        <input type="hidden" name="todo_id" value="">

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                      <button type="submit" class="btn btn-danger">ลบ</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              @else
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col">
                    <p class="text-center fs-3"><i class="far fa-list-alt text-secondary"></i></p>
                    <p class="text-secondary text-center">ยังไม่มีรายการ</p>
                  </div>
                </div>
              </div>
              @endif

            </div>
        </div>
      </div>




    </div>
    <div class="footer">
      <p class="fw-light">I4ymi project</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>

<!-- เทรนงาน 6 ส.ค. 64 เวลา บ่าย 3 - 4 โมงเย็น
ชื่อใน zoom : 16dream/น้องขวัญ/ขอนแก่น


นายณภัทร กันทำ
Naphat Kantham
ชื่อเล่น : ดรีม
อายุ : 24
0967913787 -->
