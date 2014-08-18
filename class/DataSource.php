<?php 

	class DataSource{

		public $url;
		public $user;
		public $pass;

		// Get and set
		public function __get($name){
			return $this->$name;
		}

		public function __set($name,$value){
			$this->$name = $value;
		}

		// Constructeur
		public function __construct($pUrl = "mysql:host=localhost:3307;dbname=events",
									$pUser = "root",
									$pPass = "root"){
			$this->url = $pUrl;
			$this->user = $pUser;
			$this->pass = $pPass;
		}

		// Méthode pour rechercher le patient
		public function getEvent($pId){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from event where id = ?";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->execute(array($pId));

			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
				// Creer un nouveau event
				return new bigevent($result['id'],
										$result['title'],
										$result['url'],
										$result['class'],
										$result['start'],
										$result['end'],
										$result['desc'],
										$result['owner']);
			}

		}

		// Method to insert a new invite
		public function addInvite($pInvite){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "INSERT INTO listeinvite(reponse,nom,prenom,email,telephone,invites,eupdate) VALUES(:rep,:nom,:prenom,:email,:tel,:invites,:eupdate)";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':rep', $pInvite->rep);
			$stmt->bindParam(':nom', $pInvite->nom);
			$stmt->bindParam(':prenom', $pInvite->prenom);
			$stmt->bindParam(':email', $pInvite->email);
			$stmt->bindParam(':tel', $pInvite->tel);
			$stmt->bindParam(':invites', $pInvite->invites);
			$stmt->bindParam(':eupdate', $pInvite->eupdate);
			$stmt->execute();

			$cn = null;
		}

		public function getInvites(){
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from listeinvite ORDER BY id ASC";

			// Execution
			$ds = $cn->query($req);

			$liste = new ArrayObject();

			while($result = $ds->fetch(PDO::FETCH_ASSOC)){
				$unInvite = new invite($result['id'],
					$result['reponse'],
					$result['nom'],
					$result['prenom'],
					$result['email'],
					$result['telephone'],
					$result['invites'],
					$result['eupdate']);
				$liste->append($unInvite);
			}

			$cn = null;

			return $liste;
		}

		public function addUsers($pUser,$pPass,$pSalt){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "INSERT INTO users(username,password,salt) VALUES(:user,:pass,:salt)";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':user', $pUser);
			$stmt->bindParam(':pass', $pPass);
			$stmt->bindParam(':salt', $pSalt);
			$stmt->execute();

			$cn = null;
		}

		public function getUsers(){
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from users ORDER BY username ASC";

			// Execution
			$ds = $cn->query($req);

			$liste = new ArrayObject();

			while($result = $ds->fetch(PDO::FETCH_ASSOC)){
				$liste->append($result['username']);
			}

			$cn = null;

			return $liste;
		}

		public function delUsers($pUser){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "DELETE FROM users WHERE username = :user";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':user', $pUser);
			$stmt->execute();

			$cn = null;
		}

		public function getSalt($pCode){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT salt from users where username = :code";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':code', $pCode);
			$stmt->execute();

			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
				return $result['salt'];
			}

			return null;
		}

		public function validUser($pCode,$pPass){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT username from users where username = :code and password = :pass";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':code', $pCode);
			$stmt->bindParam(':pass', $pPass);
			$stmt->execute();

			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
				// Creer un nouveau produit et l'ajouter a la liste
				return $result['username'];
			}

			return null;
		}

/* Extra methods
		// Méthode pour valider l'utilisateur
		public function validUser($pCode,$pPass){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from patient where code = ? and password = ?";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->execute(array($pCode,$pPass));

			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
				return new Patient($result['code'],
									$result['nom'],
									$result['prenom'],
									$result['telephone'],
									$result['password'],
									$result['email'],
									$result['docteur'],
									$result['personneurgence'],
									$result['telephoneurgence'],
									$result['prescription'],
									$result['allergies'],
									$result['autre'],
									$result['codedoc']);
			}

			return null;
		}

		// Méthode pour rechercher le patient
		public function getPatient($pCode){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from patient where code = ?";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->execute(array($pCode));

			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
				// Creer un nouveau produit et l'ajouter a la liste
				return new Patient($result['code'],
										$result['nom'],
										$result['prenom'],
										$result['telephone'],
										$result['password'],
										$result['email'],
										$result['docteur'],
										$result['personneurgence'],
										$result['telephoneurgence'],
										$result['prescription'],
										$result['allergies'],
										$result['autre'],
										$result['codedoc']);
			}

		}

		//Méthode pour modifier les contacts urgence
		public function modPatientUrgence($pCode,$pPers,$pTel){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "UPDATE patient SET personneurgence = :pers, telephoneurgence = :tel WHERE code = :code";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':pers', $pPers);
			$stmt->bindParam(':tel', $pTel);
			$stmt->bindParam(':code', $pCode);
			$stmt->execute();

			$cn = null;
		}

		//Méthode pour modifier les allergies
		public function modPatientAllergie($pCode,$pAllergie){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "UPDATE patient SET allergies = :allergies WHERE code = :code";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':allergies', $pAllergie);
			$stmt->bindParam(':code', $pCode);
			$stmt->execute();

			$cn = null;
		}

		//Méthode pour modifier les allergies
		public function modPatientAutre($pCode,$pOther){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "UPDATE patient SET autre = :autre WHERE code = :code";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':autre', $pOther);
			$stmt->bindParam(':code', $pCode);
			$stmt->execute();

			$cn = null;
		}

		// Méthode pour aller chercher les 3 derniers articles
		public function getArticles(){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from articles ORDER BY datepub DESC LIMIT 3";

			// Execution
			$ds = $cn->query($req);

			$liste = new ArrayObject();

			while($result = $ds->fetch(PDO::FETCH_ASSOC)){
				// Creer un nouveau produit et l'ajouter a la liste
				$article = new Article($result['id'],$result['titre'],$result['desc'],$result['datepub']);
				$liste->append($article);
			}

			$cn = null;

			return $liste;
		}

		// Méthode pour aller chercher tout les articles
		public function getArticlesAdmin(){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from articles ORDER BY datepub ASC";

			// Execution
			$ds = $cn->query($req);

			$liste = new ArrayObject();

			while($result = $ds->fetch(PDO::FETCH_ASSOC)){
				// Creer un nouveau produit et l'ajouter a la liste
				$article = new Article($result['id'],$result['titre'],$result['desc'],$result['datepub']);
				$liste->append($article);
			}

			$cn = null;

			return $liste;
		}

		// Méthode pour supprimer un article
		public function delArticle($pId){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "DELETE FROM articles WHERE id = :id";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':id', $pId);
			$stmt->execute();

			$cn = null;
		}

		// Méthode pour inserer un article
		public function addArticle($pTitre,$pDesc,$pDate){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "INSERT INTO articles(titre,`desc`,datepub) VALUES(:titre,:undesc,:undate)";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':titre', $pTitre);
			$stmt->bindParam(':undesc', $pDesc);
			$stmt->bindParam(':undate', $pDate);
			$stmt->execute();

			$cn = null;
		}

		// Méthode pour inserer un rendez-vous
		public function insertRv($pDate,$pHeure,$pMinute,$pTitre,$pLink,$pPatient,$pCodeDoc){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "INSERT into calendar_" . $pCodeDoc . " (caldate,calheure,calmin,caltitle,callink,patient) values(:pDate,:pHeure,:pMin,:title,:link,:patient)";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':pDate', $pDate);
			$stmt->bindParam(':pHeure', $pHeure);
			$stmt->bindParam(':pMin', $pMinute);
			$stmt->bindParam(':title', $pTitre);
			$stmt->bindParam(':link', $pLink);
			$stmt->bindParam(':patient', $pPatient);
			$stmt->execute();

			$cn = null;
		}

		// Méthode pour aller chercher tout les patients
		public function getPatientFilter($pNom,$pPrenom){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from patient WHERE prenom = :unprenom AND nom = :unnom";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':unprenom', $pPrenom);
			$stmt->bindParam(':unnom', $pNom);
			$stmt->execute();

			$liste = new ArrayObject();

			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
				// Creer un nouveau produit et l'ajouter a la liste
				$patient = new Patient($result['code'],
										$result['nom'],
										$result['prenom'],
										$result['telephone'],
										$result['password'],
										$result['email'],
										$result['docteur'],
										$result['personneurgence'],
										$result['telephoneurgence'],
										$result['prescription'],
										$result['allergies'],
										$result['autre'],
										$result['codedoc']);
				$liste->append($patient);
			}

			$cn = null;

			return $liste;
		}

		// Méthode pour ajouter un patient
		public function addPatient($pNom,
									$pPrenom,
									$pTel,
									$pPass,
									$pEmail,
									$pDoc,
									$pPersUrg,
									$pTelUrg,
									$pPres,
									$pAller,
									$pAutre,
									$pCodedoc){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "INSERT into patient (prenom,nom,telephone,personneurgence,telephoneurgence,password,email,docteur,prescription,allergies,autre,codedoc)
					 values(:prenom,:nom,:telephone,:persurg,:telurg,:pass,:email,:doc,:pres,:aller,:autre,:codedoc)";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':prenom', $pPrenom);
			$stmt->bindParam(':nom', $pNom);
			$stmt->bindParam(':telephone', $pTel);
			$stmt->bindParam(':persurg', $pPersUrg);
			$stmt->bindParam(':telurg', $pTelUrg);
			$stmt->bindParam(':pass', $pPass);
			$stmt->bindParam(':email', $pEmail);
			$stmt->bindParam(':doc', $pDoc);
			$stmt->bindParam(':pres', $pPres);
			$stmt->bindParam(':aller', $pAller);
			$stmt->bindParam(':autre', $pAutre);
			$stmt->bindParam(':codedoc', $pCodedoc);
			$stmt->execute();

			$cn = null;
		}

		// Méthode pour modifier un patient
		public function modPatient($pCode,
									$pNom,
									$pPrenom,
									$pTel,
									$pPass,
									$pEmail,
									$pDoc,
									$pPersUrg,
									$pTelUrg,
									$pPres,
									$pAller,
									$pAutre,
									$pCodeDoc){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "UPDATE patient 
					SET prenom = :prenom, 
					nom = :nom, 
					telephone = :telephone, 
					personneurgence = :persurg, 
					telephoneurgence = :telurg, 
					password = :pass, 
					email = :email, 
					docteur = :doc, 
					prescription = :pres, 
					allergies = :aller, 
					autre = :autre,
					codedoc = :codedoc 
					WHERE code = :code";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':code', $pCode);
			$stmt->bindParam(':prenom', $pPrenom);
			$stmt->bindParam(':nom', $pNom);
			$stmt->bindParam(':telephone', $pTel);
			$stmt->bindParam(':persurg', $pPersUrg);
			$stmt->bindParam(':telurg', $pTelUrg);
			$stmt->bindParam(':pass', $pPass);
			$stmt->bindParam(':email', $pEmail);
			$stmt->bindParam(':doc', $pDoc);
			$stmt->bindParam(':pres', $pPres);
			$stmt->bindParam(':aller', $pAller);
			$stmt->bindParam(':autre', $pAutre);
			$stmt->bindParam(':codedoc', $pCodeDoc);
			$stmt->execute();

			$cn = null;
		}

		// Méthode pour rechercher les docteurs
		public function getDocteur(){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from docteur";

			// Execution
			$ds = $cn->query($req);

			$liste = new ArrayObject();

			while($result = $ds->fetch(PDO::FETCH_ASSOC)){
				// Creer un nouveau produit et l'ajouter a la liste
				$docteur = new Docteur($result['code'],$result['nom'],$result['prenom']);
				$liste->append($docteur);
			}

			$cn = null;

			return $liste;

		}

		// Méthode pour rechercher les docteurs
		public function getDocteurCode($pCode){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from docteur where code = :code";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':code', $pCode);
			$stmt->execute();

			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
				// Creer un nouveau produit et l'ajouter a la liste
				return new Docteur($result['code'],$result['nom'],$result['prenom']);
			}

			return null;

		}

		// Méthode pour supprimer un docteur
		public function delDocteur($pCode){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "DELETE FROM docteur WHERE code = :code";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':code', $pCode);
			$stmt->execute();

			$cn = null;
		}

		// Méthode pour ajouter un docteur
		public function addDocteur($pNom,$pPrenom){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "INSERT into docteur (nom,prenom)
					 values(:nom,:prenom)";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':nom', $pNom);
			$stmt->bindParam(':prenom', $pPrenom);
			$stmt->execute();

			$cn = null;
		}

		public function getDocteurNom($pNom,$pPrenom){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from docteur where nom = :nom and prenom = :prenom";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':nom', $pNom);
			$stmt->bindParam(':prenom', $pPrenom);
			$stmt->execute();

			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
				return new Docteur($result['code'],$result['nom'],$result['prenom']);
			}

			$cn = null;
		}

		public function createTableDoc($pTable){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "CREATE TABLE " . $pTable . " (
					callid INT AUTO_INCREMENT NOT NULL,
					caldate date NOT NULL,
					calheure INT NOT NULL,
					calmin INT NOT NULL,
					caltitle text NOT NULL,
					callink text NOT NULL,
					patient int(11) DEFAULT NULL,
					PRIMARY KEY (callid)
					)";

			// Execution
			$cn->exec($req);

			$cn = null;
		}

		public function getCalendar($pCode,$pDate){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from calendar_" . $pCode . " WHERE caldate = :date";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':date', $pDate);
			$stmt->execute();

			$liste = new ArrayObject();

			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
				$event = new Event($result['callid'],
									$result['caldate'],
									$result['calheure'],
									$result['calmin'],
									$result['caltitle'],
									$result['callink'],
									$result['patient']);
				$liste->append($event);
			}

			$cn = null;

			return $liste;
		}

		public function getCalendarAll($pCode){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from calendar_" . $pCode . " ORDER BY caldate asc";

			// Execution
			$ds = $cn->query($req);

			$liste = new ArrayObject();

			while($result = $ds->fetch(PDO::FETCH_ASSOC)){
				$event = new Event($result['callid'],
									$result['caldate'],
									$result['calheure'],
									$result['calmin'],
									$result['caltitle'],
									$result['callink'],
									$result['patient']);
				$liste->append($event);
			}

			$cn = null;

			return $liste;
		}

		public function getEvent($pCodeDoc,$pDate,$pHeure,$pMin){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "SELECT * from calendar_".$pCodeDoc." where caldate = :date and calheure = :heure and calmin = :min";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':date', $pDate);
			$stmt->bindParam(':heure', $pHeure);
			$stmt->bindParam(':min', $pMin);
			$stmt->execute();

			while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
				return new Event($result['callid'],
									$result['caldate'],
									$result['calheure'],
									$result['calmin'],
									$result['caltitle'],
									$result['callink'],
									$result['patient']);
			}

			$cn = null;
		}

		// Méthode pour supprimer un event
		public function delEvent($pTable,$pIdEvent){
			// La connexion
			$cn = new PDO($this->url,$this->user,$this->pass);

			// La requete
			$req = "DELETE FROM " . $pTable . " WHERE callid = :code";

			// Execution
			$stmt = $cn->prepare($req);
			$stmt->bindParam(':code', $pIdEvent);
			$stmt->execute();

			$cn = null;
		}
		fin de extra method
		*/

	}

?>