<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPT FIS R&D - Research and Development Da Nang</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4a90e2, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }
        .title {
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .upload-container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 420px;
            transition: transform 0.3s ease-in-out;
        }
        .upload-container:hover {
            transform: translateY(-5px);
        }
        .custom-file-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px dashed #4a90e2;
            background-color: #f9f9f9;
            padding: 25px;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .custom-file-upload:hover {
            background: #e0e0e0;
        }
        .custom-file-upload .icon svg {
            height: 80px;
            fill: #4a90e2;
        }
        .custom-file-upload input {
            display: none;
        }
        .file-list {
            margin-top: 20px;
            text-align: left;
            font-size: 14px;
            color: #333;
        }
        .file-list ul {
            list-style-type: none;
            padding: 0;
        }
        .file-list ul li {
            background: #efefef;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }
        button {
            background: #4a90e2;
            color: white;
            border: none;
            padding: 14px 22px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease-in-out;
            width: 100%;
            margin-top: 20px;
        }
        button:hover {
            background: #357abd;
        }
    </style>
</head>
<body>
    <div class="title">FPT FIS R&D - Research and Development Da Nang</div>
    <div class="upload-container">
        <form action="{{ route('report.export') }}" method="post" id="upload-form" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <label class="custom-file-upload">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z"></path></svg>
                </div>
                <div class="text">
                    <span>Click to upload files</span>
                </div>
                <input type="file" id="file" name="file" multiple>
            </label>
            <div class="file-list" id="file-list">
                <strong>Selected Files:</strong>
                <ul></ul>
            </div>
            <button type="submit">Upload Files</button>
        </form>
    </div>
    <script>
    $(document).ready(function(){
        $('#file').on('change', function() {
            let fileList = $('#file-list ul');
            fileList.empty();
            let files = this.files;
            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    fileList.append('<li>' + files[i].name + '</li>');
                }
            }
        });
    });
</script>

</body>
</html>
