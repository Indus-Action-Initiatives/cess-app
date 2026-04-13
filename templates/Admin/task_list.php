<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Labour Cess</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo webURL ?>admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Labour Cess</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<!-- Task List -->
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <strong>Task List</strong>
          <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width: 160px;">
              <option>Complete</option>
              <option>Pending</option>
            </select>
            <select class="form-select form-select-sm" style="width: 300px;">
              <option>Digital Signature Establishment Registration (LUBR)</option>
            </select>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
          <table id="labourCessTable" class="table table-striped align-middle">
            <thead class="table-success">
              <tr>
                <th>#</th>
                <th>File No.</th>
                <th>Establishment Type</th>
                <th>Assessment Name</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <!-- <tbody>
              <tr>
                <td>01</td>
                <td>LUBR/0084/24-25</td>
                <td>Complete</td>
                <td>NEW TEST - 08-04-2024</td>
                <td>In Process</td>
                <td class="text-danger">11/04/2024</td>
                <td><button class="btn btn-outline-success btn-sm">Digital Sign</button></td>
              </tr>
            </tbody> -->
          </table>
        </div>
          <script>
                  $(document).ready(function() {
                    var webURL='<?php echo webURL; ?>';
                      $('#labourCessTable').DataTable({
                          processing: true,
                          serverSide: true,  // Set to true if you want server-side processing
                          //dom: 'Bfrtip', // Enables Buttons
                          // buttons: [
                          //     {
                          //         extend: 'copy',
                          //         text: 'Copy',
                          //         className: 'btn btn-secondary'
                          //     },
                          //     {
                          //         extend: 'csv',
                          //         text: 'CSV',
                          //         className: 'btn btn-success'
                          //     },
                          //     {
                          //         extend: 'excel',
                          //         text: 'Excel',
                          //         className: 'btn btn-info'
                          //     },
                          //     {
                          //         extend: 'pdf',
                          //         text: 'PDF',
                          //         className: 'btn btn-danger'
                          //     },
                          //     {
                          //         extend: 'print',
                          //         text: 'Print',
                          //         className: 'btn btn-primary'
                          //     }
                          // ],
                          ajax: {
                              url: webURL+"admin/getlabourData",
                              type: "GET"
                          }
                      });
                  });
                  </script>
        </div>
      </div>

      <!-- View List -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <strong>View List</strong>
          <div>
            <button class="btn btn-outline-primary btn-sm">Search</button>
            <button class="btn btn-outline-success btn-sm">Export</button>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-hover align-middle">
            <thead class="table-success">
              <tr>
                <th>#</th>
                <th>File No.</th>
                <th>Date</th>
                <th>Assessment Name</th>
                <th>Establishment Type</th>
                <th>Current Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>01</td>
                <td>LUBR/0176/24-25</td>
                <td>10/01/2025</td>
                <td>Testing this file</td>
                <td>Complete</td>
                <td>Proposal Approved</td>
                <td><button class="btn btn-outline-primary btn-sm">View</button></td>
              </tr>
              <tr>
                <td>02</td>
                <td>LUBR/0173/24-25</td>
                <td>03/01/2025</td>
                <td>Residential building of Deepak testing</td>
                <td>Complete</td>
                <td>Approved (Pending for Payment)</td>
                <td><button class="btn btn-outline-primary btn-sm">View</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>