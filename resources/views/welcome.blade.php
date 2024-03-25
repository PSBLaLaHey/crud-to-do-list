<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <title>TO DO List</title>
</head>

<body>
    <h1>My To Do List</h1>


    <div class="container mt-3">
        {{-- <for action="" {{ url('/') }} method="POST">
            @csrf
            <input type="text" placeholder="title" name="title">
            <input type="text" placeholder="des" name="des">

        </form> --}}
        <button class="btn btn-primary" onclick="addTodo()">เติม งาน</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ลำดับ</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">การกระทำ</th>
                </tr>
            </thead>
            {{-- content --}}
            <tbody>
                @if ($todo_lists !== null)
                    @foreach ($todo_lists as $index => $todo)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $todo->td_name }}</td>
                            <td>

                                @if ($todo->td_status === 0)
                                    ยังไม่เสร็จ
                                @else
                                    เสร็จแล้ว
                                @endif
                            </td>
                            <td class="d-flex gap-2">
                                <div style="cursor: pointer">
                                    ✅
                                </div>
                                <div onclick="editTodo({{$todo->td_id}})" style="cursor: pointer">
                                    🖊️
                                </div>
                                <div onclick="deleteTodo({{ $todo->td_id }})"style="cursor: pointer">
                                    🗑️
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <p>ไม่มีข้อมูล...............</p>
                @endif
            </tbody>
        </table>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script>
    const addTodo = () => {
        Swal.fire({
            title: "ใส่กิจกรรมที่ต้องทำ",
            html: '<input id="title" placeholder = "หัวข้อ" class="swal2-input">' +
                '<input id="des" placeholder = "คำอธิบาย" class="swal2-input">',

            showCancelButton: true,
            confirmButtonText: "เติม",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    const title = document.getElementById('title').value;
                    const des = document.getElementById('des').value;

                    const response = await fetch('/', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            title,
                            des
                        })
                    });
                } catch (error) {
                    Swal.showValidationMessage(`Request failed: ${error} `);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then(async(result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: "success",
                    title: `สำเร็จ`,
                    imageUrl: result.value.avatar_url
                });
                window.location.reload()
            }
        });
    }
    const deleteTodo = async(td_id) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(async(result) => {
            if (result.isConfirmed) {
                const response = await fetch(`/todo/${td_id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },

                    });
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
                window.location.reload();

            }
        });
    }
    const editTodo = (td_id) => {
        Swal.fire({
            title: "แก้ไข",
            html: '<input id="title" placeholder = "หัวข้อ" class="swal2-input">' +
                '<input id="des" placeholder = "คำอธิบาย" class="swal2-input">',

            showCancelButton: true,
            confirmButtonText: "แก้",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    const title = document.getElementById('title').value;
                    const des = document.getElementById('des').value;

                    const response = await fetch(`/todo/${td_id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            title,
                            des
                        })
                    });
                    if(response.status === 200){
                        window.location.reload();
                    }
                } catch (error) {
                    Swal.showValidationMessage(`Request failed: ${error} `);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then(async(result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: "success",
                    title: `สำเร็จ`,
                    imageUrl: result.value.avatar_url
                });

            }
        });
    }
</script>

</html>
