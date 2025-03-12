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
                <div class="text">
                    <span>Click to upload files</span>
                </div>
                <input type="file" id="file" name="files[]" multiple>
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
