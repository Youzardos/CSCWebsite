<?php
            /* Récupération des valeurs des champs du formulaire */
            if (get_magic_quotes_gpc())
            {
              $nom_prenom             = stripslashes(trim($_POST['nom_prenom ']));
              $email    = stripslashes(trim($_POST['email']));
              $sujet        = stripslashes(trim($_POST['sujet']));
              $message        = stripslashes(trim($_POST['message']));
            }
            else
            {
              $nom_prenom             = trim($_POST['nom_prenom ']);
              $email    = trim($_POST['email']);
              $sujet        = trim($_POST['sujet']);
              $message        = trim($_POST['message']);
            }
 
            /* Expression régulière permettant de vérifier si le
            * format d'une adresse e-mail est correct */
            $regex_mail = '/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i';
 
            /* Expression régulière permettant de vérifier qu'aucun
            * en-tête n'est inséré dans nos champs */
            $regex_head = '/[\n\r]/';
 
            /* Si le formulaire n'est pas posté de notre site on renvoie
            * vers la page d'accueil */
            if($_SERVER['HTTP_REFERER'] != 'http://www.csc.ma/contact.php')
            {
              header('Location: http://www.csc.ma/');
            }
            /* On vérifie que tous les champs sont remplis */
            elseif (empty($nom) 
                   || empty($email)
                   || empty($sujet)
                   || empty($message))
            {
              echo "<center>Tous les champs doivent être renseignés</center> <br><a href='../'>Retour au page d'accueil...</a>";
            }
            /* On vérifie que le format de l'e-mail est correct */
            elseif (!preg_match($regex_mail, $email))
            {
              echo "<center>L'adresse email n'est pas valide</center> <br><a href='../'>Retour au page d'accueil...</a>";
            }
            /* On vérifie qu'il n'y a aucun header dans les champs */
            elseif (preg_match($regex_head, $email)
                    || preg_match($regex_head, $nom_prenom)
                    || preg_match($regex_head, $sujet))
            {
                echo "<center>En-têtes interdites dans les champs du formulaire</center> <br><a href='../'>Retour au page d'accueil...</a>";
            }
            /* Destinataire (votre adresse e-mail) */
            $to = 'xxx@xxx.com';
 
            /* Construction du message */
            $msg  = 'contact form,'."\r\n\r\n";
            $msg .= 'sujet :'.$sujet."\r\n";
            $msg .= '***************************'."\r\n";
            $msg .= $message."\r\n";
            $msg .= '***************************'."\r\n";
 
            /* En-têtes de l'e-mail */
            $headers = 'From: '.$nom_prenom .' <'.$email.'>'."\r\n\r\n";
 
            /* Envoi de l'e-mail */
            if (mail($to, $sujet, $msg, $headers))
            {
                echo "<center>E-mail envoyé avec succès</center> <br><a href='../'>Retour au page d'accueil...</a>";
            }
            else
            {
                echo "<center>Erreur d'envoi de l'e-mail</center> <br><a href='../'>Retour au page d'accueil...</a>";
            }
?>
