<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php foreach ($user as $user) : ?>
    <!doctype html>
    <html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?> - <?= $user['name'] ?></title>
        <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
    </head>

    <body>
        <header>
            <div class="collapse bg-dark" id="navbarHeader">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-md-7 py-4">
                            <h4 class="text-white">Sobre</h4>
                            <p class="text-muted"><?= $user['about'] ?></p>
                        </div>
                        <div class="col-sm-4 offset-md-1 py-4">
                            <h4 class="text-white">Contato</h4>
                            <ul class="list-unstyled">
                                <?php if (empty($user["phone"])) : ?>
                                <?php else : ?>
                                    <li class="text-white"><?= $user['phone'] ?></li>
                                <?php endif ?>
                                <li><a href="mailto:<?= $user['email'] ?>" target="_blank" title="E-mail" class="text-white"><?= $user['email'] ?></a></li>
                                <?php if (empty($user["instagram"])) : ?>
                                <?php else : ?>
                                    <li><a href="<?= $user['instagram'] ?>" target="_blank" title="Instagram" class="text-white"><?= $user['instagram'] ?></a></li>
                                <?php endif ?>
                                <?php if (empty($user["facebook"])) : ?>
                                <?php else : ?>
                                    <li><a href="<?= $user['facebook'] ?>" target="_blank" title="Facebook" class="text-white"><?= $user['facebook'] ?></a></li>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container">
                    <a href="<?= base_url() ?>" class="navbar-brand d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                            <circle cx="12" cy="13" r="4" />
                        </svg>
                        <strong><?= $user['name'] ?></strong>
                    </a>
                    <?php if (isset($_SESSION["logged_user"]["id"])) : ?>
                        <button data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-primary">Editar</button>
                        <a href="<?= base_url() ?>login/logout" class="btn btn-danger">Sair</a>
                    <?php else : ?>
                    <?php endif ?>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
            <div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editLabel">Editar informações</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="<?= base_url() ?>home/update">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control" name="name" value="<?= $user['name'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">WhatsApp</label>
                                    <input type="text" class="form-control phone" name="phone" value="<?= $user['phone'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" class="form-control" name="instagram" value="<?= $user['instagram'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" value="<?= $user['facebook'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sobre</label>
                                    <textarea class="form-control" name="about"><?= $user['about'] ?></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="album py-5 bg-light">
                <div class="container">
                    <?php if (isset($_SESSION["logged_user"]["id"])) : ?>
                        <p><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNewAlbum">Criar novo álbum</button></p>
                        <div class="modal fade" id="createNewAlbum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createNewAlbumLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createNewAlbumLabel">Criar novo álbum</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <?php echo form_open_multipart('' . base_url() . 'home/createAlbum'); ?>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nome</label>
                                            <input type="text" class="form-control" name="album" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Descrição</label>
                                            <textarea class="form-control" name="description"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class=" control-label">Preço</label>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                <span class="bootstrap-touchspin-prefix input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </span>
                                                <input type="text" class="form-control price" name="price" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Capa</label>
                                            <input type="file" class="form-control" name="image" accept=".jpeg, .gif, .jpg, .png" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-primary">Criar</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                    <?php endif ?>
                    <? if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                    } else {
                        echo "";
                    } ?>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        <?php foreach ($list as $list) : ?>
                            <div class="col">
                                <div class="card shadow-sm">
                                    <a href="<?= base_url() ?>album/<?= $list['slug'] ?>" title="<?= $list['album'] ?>"><img src="<?= base_url() ?>assets/album/<?= $list['slug'] ?>/<?= $list['image'] ?>" alt="<?= $list['album'] ?>" class="bd-placeholder-img card-img-top" width="100%" height="225" style="object-fit: cover;"></a>
                                    <div class="card-body">
                                        <h5 onclick="javascript:location.href='<?= base_url() ?>album/<?= $list['slug'] ?>'" title="<?= $list['album'] ?>" style="cursor:pointer"><?= $list['album'] ?></h5>
                                        <p onclick="javascript:location.href='<?= base_url() ?>album/<?= $list['slug'] ?>'" title="<?= $list['album'] ?>" style="cursor:pointer" class="card-text"><?= $list['description'] ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <?php if (isset($_SESSION["logged_user"]["id"])) : ?>
                                                    <button data-bs-toggle="modal" data-bs-target="#editAlbum<?= $list['slug'] ?>" class="btn btn-primary">Editar</button>
                                                    <button data-bs-toggle="modal" data-bs-target="#coverAlbum<?= $list['slug'] ?>" class="btn btn-success">Capa</button>
                                                    <button data-bs-toggle="modal" data-bs-target="#deleteAlbum<?= $list['slug'] ?>" class="btn btn-danger">Apagar</button>
                                                <?php else : ?>
                                                <?php endif ?>
                                            </div>
                                            <strong>R$ <?= number_format($list['price'] / 100, 2, ',', '.'); ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="editAlbum<?= $list['slug'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editAlbum<?= $list['slug'] ?>Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editAlbum<?= $list['slug'] ?>Label">Editar álbum</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="post" action="<?= base_url() ?>home/updateAlbum/<?= $list['slug'] ?>">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nome</label>
                                                    <input type="text" class="form-control" name="album" value="<?= $list['album'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Descrição</label>
                                                    <textarea class="form-control" name="description"><?= $list['description'] ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class=" control-label">Preço</label>
                                                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                        <span class="bootstrap-touchspin-prefix input-group-prepend">
                                                            <span class="input-group-text">R$</span>
                                                        </span>
                                                        <input type="text" class="form-control price" name="price" value="<?= $list['price'] ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="coverAlbum<?= $list['slug'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="coverAlbum<?= $list['slug'] ?>Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="coverAlbum<?= $list['slug'] ?>Label">Alterar capa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <?php echo form_open_multipart('' . base_url() . 'home/updateCover'); ?>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Capa</label>
                                                <input type="file" class="form-control" name="image" accept=".jpeg, .gif, .jpg, .png" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="slug" id="slug" value="<?= $list['slug'] ?>">
                                            <input type="hidden" name="currentFile" id="currentFile" value="<?= $list['image'] ?>">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary">Alterar</button>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="deleteAlbum<?= $list['slug'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAlbum<?= $list['slug'] ?>Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteAlbum<?= $list['slug'] ?>Label">Apagar álbum</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <p>Tem a certeza que deseja <strong>apagar</strong> o álbum <strong><?= $list['album'] ?></strong>?</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                                            <a href="<?= base_url() ?>home/deleteAlbum/<?= $list['slug'] ?>" class="btn btn-primary">Sim</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </main>

        <footer class="text-muted py-5">
            <div class="container">
                <p class="float-end mb-1">
                    <a href="#">Subir</a>
                </p>
                <p class="mb-1">&copy; Copyright <?= date('Y'); ?> <?= $user['name'] ?></p>
                <p class="mb-0"><a href="https://www.kcteles.com/" title="Desenvolvido por KC Teles" target="_blank">Desenvolvido por KC Teles</a></p>
            </div>
        </footer>
        <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.price').mask('000.000.000.000.000,00', {
                    reverse: true
                });

                $(".price").change(function() {
                    $("#value").html($(this).val().replace(/\D/g, ''))
                })

            });
            var SPMaskBehavior = function(val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                },
                spOptions = {
                    onKeyPress: function(val, e, field, options) {
                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };

            $('.phone').mask(SPMaskBehavior, spOptions);
        </script>
    </body>

    </html>
<?php endforeach; ?>