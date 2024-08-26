<!-- Accordion Content -->
<tr>
                <?php include '../app/views/modals/modal_add/admin/sub_pekerjaan_add.php'; ?>
                    <td colspan="3">
                        <div id="collapse<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample<?= $index ?>">
                            <div class="accordion-body">
                            <div class="card ">
                              <h5 class="card-header bg-info text-dark mt-0 d-flex justify-content-between align-items-center">
                                  <span style="font-weight: bold;">Sub <?= $item['nama_pekerjaan'] ?></span>
                                  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sub-tambah-<?= $item['id_m_pekerjaan'] ?>">
                                      <i class='bx bx-plus-medical' width='500px' name="btambah"></i> <span class="span-aksi">Add Sub</span>
                                  </button>
                              </h5>
                                <table class="table bg-light table-striped table-borderless m-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="col-1">ID</th>
                                            <th scope="col">Nama Sub Pekerjaan</th>
                                            <th scope="col" class="col-2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Subtasks -->
                                        <?php foreach ($item['sub_pekerjaan'] as $subtask): ?>
                                            <tr>
                                                <td><?= $subtask['id'] ?></td>
                                                <td><?= $subtask['name'] ?></td>
                                                <td>
                                                  <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#sub-hapus-<?= $subtask['id'] ?>">
                                                        <i class='bx bxs-trash-alt'></i><span class="span-aksi">Delete</span>
                                                    </button>
                                                    <button class="btn btn-warning mt-1" data-bs-toggle="modal" data-bs-target="#sub-ubah-<?=$subtask['id']?>">
                                                      <i class='bx bxs-edit-alt '></i><span class="span-aksi">Edit</span>
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal UD Subtasks -->
                                            <?php include '../app/views/modals/modal_ud/admin/sub_pekerjaan_ud.php';?>
                                            
                                        <?php endforeach; ?>
                                        <tr><td class="bg-info" colspan="3"></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>