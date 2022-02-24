<?php
function showdb($db)
// ausgabe db
{

    if (!isset($_GET['action']) or $_GET['action'] == "deleteQuestion" or $_GET['action'] == "delete") {
        $daten = $db->query("SELECT id,company,contact,telephone, address, user, create_time, update_time FROM customer");
        // or die($db->error);
        deleteSafely($db);
        if (isset($_SESSION['login']) and $_SESSION['login'] == true) {
            echo ' 
                <h2 class="pb-3">Kunden</h2>
                    <div class="table-responsive-xxl">
                        <table class="mb-4 table">
                            <tr>
                                <th>ID</th>
                                <th>Firmenname</th>
                                <th>Ansprechperson</th>
                                <th>Telefonnummer</th>
                                <th>Adressfeld</th>
                                <th>Erstellt<br>Geändert</th>
                                <th></th>
                                <th></th>
                        </tr>
            ';
            while ($row = $daten->fetch_object()) {
                echo '
                    <tr>
                    <td>' . $row->id . '</td>
                    <td>' . $row->company . '</td>
                    <td>' . $row->contact, '</td>
                    <td>' . $row->telephone . '</td>
                    <td>' . $row->address . '</td>
                ';
                if ($_SESSION['username'] == $row->user) {
                    echo '
                        <td class="created">' . $row->create_time . ' ' . $row->update_time . '</td>
                        <td class="update"><a class="btn btn-outline-light" role="button" method="get" href="index.php?action=update&id=' . $row->id . '">update</a></td>
                        <td class="delete"><a class="btn btn-outline-light" role="button" method="get" href="index.php?action=deleteQuestion&id=' . $row->id . '">löschen</a></td>
                    ';
                } else {
                    echo '
                        <td class="created"></td>
                        <td class="update"></td>
                        <td class="delete"></td>
                    ';
                }
                echo '</tr>';
            }
            echo '</table></div>
            ';
        } else {
            echo '
        <div class="mt-3">
        <p class="p-3">Um Kundendaten zu sehen, müssen Sie eingeloggt sein!
        </div>
        ';
        }
    }
}

function makeEntry($db)
// db eintrag
{
    if (isset($_GET['entry']) and $_GET['entry'] == '1') {
        // einfügen db
        $companyName = $db->real_escape_string(trim($_GET['companyName']));
        $contactName = $db->real_escape_string(trim($_GET['contact']));
        $telephoneNumber = $db->real_escape_string(trim($_GET['telephoneNumber']));
        $addressField = $db->real_escape_string(trim($_GET['addressField']));

        $add = $db->query("INSERT INTO customer (company, contact, telephone, address, user, create_time)
        VALUES('{$companyName}','{$contactName}','{$telephoneNumber}','{$addressField}','{$_SESSION['username']}',now())");
        if ($add) {
            echo '
        <div class="mt-3">
        <p class="green p-3">' . $_GET['companyName'] . ' eingefügt. 
        </div>
        ';
        }

        // Testeintrag
        // http://127.0.0.1/uebung/php2/Kompetenzcheck/index.php?companyName=UNITED+OPTICS+GmbH&contact=Patrick+Schmeisser&addressField=Raiffeisenplatz+1%2C+4863+Seewalchen+am+Attersee&telephoneNumber=07662%2F294+73+14&submit=
    } elseif (isset($_GET['action']) and $_GET['action'] == 'newCustomer') {

        echo '
                <h5 class="modal-title">Neukunde eintragen</h5>
            
            <form action="" method="get">
                    <div class="form-group row m-3">
                        <label for="companyName" class="col-4 col-form-label">Firmenname</label>
                        <div class="col-8">
                            <input id="companyName" name="companyName" placeholder="Muster GmbH" type="text" required="required" class="form-control" value="' . $_GET['companyName'] . '">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="contact" class="col-4 col-form-label">Ansprechperson</label>
                        <div class="col-8">
                            <input id="contact" name="contact" placeholder="Max Mustermann" type="text" required="required" class="form-control" value="' . $_GET['contact'] . '">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="addressField" class="col-4 col-form-label">Adresse</label>
                        <div class="col-8">
                            <input id="addressField" name="addressField" placeholder="Musterstr. 1, 0000-Musterhausen" type="text" required="required" class="form-control" value="' . $_GET['addressField'] . '">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label class="col-4"></label>
                        <div class="col-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Tele</div>
                                </div>
                                <input id="telephoneNumber" name="telephoneNumber" placeholder="0815/007007" type="text" required="required" class="form-control" value="' . $_GET['telephoneNumber'] . '">
                                <input type="hidden" name="entry" value="1">
                            </div>
                        </div>
                    </div>
                <div class="">
                    <button name="submit" type="submit" class="btn btn-outline-success m-4">Eintragen</button>
                </div>
            </form>
';
    }
}

function deleteSafely()
// sicherheitsfrage löschen
{
    if (isset($_GET['action']) and $_GET['action'] == 'deleteQuestion') {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            echo '
            <div class="mt-3 yellow">
            <h2>WARNUNG!!!</h2>
            <p>Soll der Eintrag mit der ID: ' . $id . ' unwiederuflich gelöscht werden?</p>
            <a class="btn btn-outline-danger mb-3" role="button" href="index.php?action=delete&id=' . $id . '">löschen</a>
            <a class="btn btn-outline-dark mb-3" role="button" href="index.php">abbrechen</a>
            </div>
            ';
        }
    }
}

function deleteEntry($db)
// löschen
{
    if (isset($_GET['action']) and $_GET['action'] == 'delete') {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            if ($id > 0) {
                $delete = $db->prepare("DELETE FROM customer WHERE id=? LIMIT 1");
                $delete->bind_param('i', $id);
                if ($delete->execute()) {
                    echo '
                    <div class="mt-3">
                    <p class="green p-3">Eintrag wurde gelöscht.</p>
                    </div>
                    ';
                }
            }
        }
    }
}

function changeEntry($db)
// ändern
{
    // abfage der Daten
    $changeEntry = false;
    if (isset($_GET['action']) and $_GET['action'] == 'update') {
        $changeEntry = true;
    }
    if ($changeEntry == true) {
        if (isset($_GET['id'])) {
            $id_read = (int) $_GET['id'];
            if ($id_read > 0) {
                $readIn = $db->prepare("SELECT id, company, contact, telephone, address FROM customer WHERE id=?");
                $readIn->bind_param("i", $id_read);
                $readIn->execute();
                $readIn->bind_result($id, $companyName, $contactName, $telephoneNumber, $addressField);
                $readIn->fetch();
            }
        }
        echo '
            <h5 class="modal-title">Kundeneintrag ändern - ID: ' . $id . '</h5>
                    <form action="index.php" method="get">
                            <div class="form-group row m-3">
                                <label for="companyName" class="col-4 col-form-label">Firmenname</label>
                                <div class="col-8">
                                    <input id="companyName" name="companyName" placeholder="Muster GmbH" type="text" required="required" class="form-control" value="' . $companyName . '">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="contact" class="col-4 col-form-label">Ansprechperson</label>
                                <div class="col-8">
                                    <input id="contact" name="contact" placeholder="Max Mustermann" type="text" required="required" class="form-control" value="' . $contactName . '">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="addressField" class="col-4 col-form-label">Adresse</label>
                                <div class="col-8">
                                    <input id="addressField" name="addressField" placeholder="Musterstr. 1, 0000-Musterhausen" type="text" required="required" class="form-control" value="' . $addressField . '">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label class="col-4"></label>
                                <div class="col-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Tele</div>
                                        </div>
                                        <input id="telephoneNumber" name="telephoneNumber" placeholder="0815/007007" type="text" required="required" class="form-control" value="' . $telephoneNumber . '">
                                        <input type="hidden" name="gesendet" value="1">
                                        <input type="hidden" name="id" value="' . $id_read . '">
                                    </div>
                                </div>
                            </div>
                            <button name="submit" type="submit" class="btn btn-outline-success m-4">ändern</button>
                    </form>
        ';
    }
    // update der Daten
    if (isset($_GET['gesendet']) and $_GET['gesendet'] == '1') {
        if (isset($_GET['id'])) {
            $id_read = (int) $_GET['id'];
            $companyName = $db->real_escape_string(trim($_GET['companyName']));
            $contactName = $db->real_escape_string(trim($_GET['contact']));
            $telephoneNumber = $db->real_escape_string(trim($_GET['telephoneNumber']));
            $addressField = $db->real_escape_string(trim($_GET['addressField']));

            $update = $db->query("UPDATE customer SET company='{$companyName}', contact='{$contactName}', telephone='{$telephoneNumber}', address='{$addressField}', update_time=now()
            WHERE id={$id_read} LIMIT 1");
            if ($update) {
                echo '
                    <div class="mt-3">
                    <p class="green p-3">Eintrag geändern.</p>
                    </div>
                    ';
            }
        }
    }
}

function login($db)
// login
{
    session_start();
    if (
        isset($_POST['username']) or $_POST['username'] != ""
        and isset($_POST['password']) or $_POST['password'] != ""
    ) {
        $userId = trim($_POST['username']);
        $userPw = trim($_POST['password']);
        $readIn = $db->prepare("SELECT password FROM user WHERE email=?");
        $readIn->bind_param("s", $userId);
        $readIn->execute();
        $readIn->bind_result($hashdb);
        $readIn->fetch();
        $readIn->free_result();
        $readIn->close();
        // pw hash verify
        if (password_verify($userPw, $hashdb)) {
            $access = $db->prepare(
                'SELECT
                email,
                firstname,
                lastname,
                update_time
                FROM
                user
                WHERE
                email = ?;'
            );
            // or die($db->error);
            $access->bind_param('s', $userId);
            $access->execute();
            $access->bind_result($id, $firstName, $surname, $update_time);
            $access->fetch();
            $_SESSION['username'] = $id;
            $_SESSION['login'] = true;
            $_SESSION['update'] = $update_time;
        } else {
            // pw ungehasht beim ersten login
            $access = $db->prepare('SELECT email, firstname, lastname, password, update_time FROM user WHERE email = ? and password = ?;');
            // or die($db->error);
            $access->bind_param("ss", $userId, $userPw);
            $access->execute();
            $access->bind_result($id, $firstName, $surname, $password, $update_time);
            $access->fetch();

            if (
                $_POST['username'] == $id and
                $_POST['password'] == $password
            ) {
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['login'] = true;
            }
        }
    }
    if (isset($_SESSION['login']) and $_SESSION['login'] == true) {
        echo '
            <a class="btn btn-outline-light ms-3" role="button" method="get" href="index.php?action=newCustomer">Kunde eintragen</a>
                <a class="btn btn-outline-light ms-3" role="button" method="get" href="index.php?logout=1">Log out</a>
                            </nav>
                </div>
                <div class="login mb-3 text-secondary">' . $_SESSION['username'] . ' ist eingeloggt</div>
            </header>
        ';
        if (isset($_POST['username'])) {
            echo '<p class="mt-3 green p-3">Erfolgreich eingeloggt.</p>';
        }
        // aufforderung pw ändern beim ersten login
        changePassword($db);
    } else {
        echo '
            <a class="btn btn-outline-light ms-3" role="button" data-bs-toggle="modal" data-bs-target="#login">Login</a>
                            </nav>
                </div>
            </header>
        ';
        if (isset($_POST['username'])) {
            echo '<p class="mt-3 yellow">Username oder Passwort falsch.</p>';
        }
        // Modal login
        echo '
            <div class="modal fade" tabindex="-1" role="dialog" id="login">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content bg-dark ">
                        <div class="modal-header">
                            <h5 class="modal-title">Login</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="?login=1" method="post">

                            <div class="modal-body">
                                <div class="form-group m-3">
                                    <label for="email" class="col-md-6">User</label>
                                    <input type="text" name="username" class="col-md-5" value="" required="required" placeholder="max@muster.at" maxlength="255" id="username">
                                </div>
                                <div class="form-group m-3">
                                    <label for="password" class="col-md-6">Passwort</label>
                                    <input type="password" class="col-md-5" name="password" required="required" placeholder="Passwort" maxlength="50">
                                </div>
                            </div>
                            <div class="modal-footer ">
                                <button type="submit" class="btn btn-outline-success">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            ';
    }
}

function logout()
// logout
{
    if (isset($_GET['logout']) and $_GET['logout'] == 1) {
        session_start();
        session_destroy();
    }
}

function changePassword($db)
// passwort ändern & hashen
{
    if (isset($_SESSION['update']) or $_SESSION['update'] != "") {
    } else {
        if (isset($_GET['changePassword']) and $_GET['changePassword'] == 1) {
            $changePassword = $db->real_escape_string(trim($_POST['password']));
            $user = $_SESSION['username'];
            $pwhash = password_hash($changePassword, PASSWORD_DEFAULT);
            $update = $db->query("UPDATE user SET password='{$pwhash}', update_time=now()
            WHERE email='{$user}' LIMIT 1");
            if ($update) {
                $_SESSION['update'] = date("Y-m-d");

                echo '
                    <div class="mt-3">
                    <p class="green p-3">Passwort geändern.</p>
                    </div>
                    ';
            }
        } else {
            echo '
            <div class="mt-3 yellow">
                <h2>Passwort bitte ändern!!!</h2>
                <p>mindestens 8 zeichen</p>
                    <form action="?changePassword=1" method="post">
                            <div class="form-group m-3">
                                <label for="password" class="col-md-6">Passwort</label>
                                <input type="password" class="col-md-5" name="password" required="required" placeholder="Passwort" maxlength="50">
                            </div>
                            <button type="submit" class="btn btn-outline-success m-3">Speichern</button>
                    </form>            
            </div>
            ';
        }
    }
}
