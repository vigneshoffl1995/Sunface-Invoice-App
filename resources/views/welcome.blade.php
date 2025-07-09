<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    body {
      background-color: #f8f9fa;
    }
    .center-box {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    .logo {
      max-width: 180px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="center-box text-center">
    <img src="{{ asset('st_inv_logo.png') }}" alt="Company Logo" class="logo" style="max-width: 25%;">
    <h2>Welcome to Invoice Management System</h2>
    <a href="{{ route('login') }}" class="btn btn-primary mt-3">Login</a>
  </div>
</body>
</html>
