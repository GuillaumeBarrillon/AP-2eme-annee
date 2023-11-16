CREATE TRIGGER `after_ligne_insert` AFTER INSERT ON `ligne`
 FOR EACH ROW
 BEGIN
 
    set @total_commande = 0;
    set @type_conso = 0;
    set @tva = 0;

    SELECT type_conso INTO @type_conso FROM commande where commande.id_commande = NEW.id_commande;

    IF @type_conso=1 THEN
		SET @tva=1.055;
	END IF;
	
    IF @type_conso=2
		THEN SET @tva=1.1;
	END IF;

    SELECT sum(total_ligne_ht) INTO @total_commande FROM ligne WHERE ligne.id_commande = NEW.id_commande;
    SET @total_commande=@total_commande*@tva;
    UPDATE commande SET total_commande=@total_commande where commande.id_commande = NEW.id_commande;
  END

2e TRIGGER

CREATE TRIGGER `after_ligne_update` AFTER UPDATE ON `ligne`
 FOR EACH ROW
 BEGIN
 
    set @total_commande = 0;
    set @type_conso = 0;
    set @tva = 0;
	
    SELECT type_conso INTO @type_conso FROM commande where commande.id_commande = NEW.id_commande;
    IF @type_conso=1 THEN
		SET @tva=1.055;
	END IF;
    IF @type_conso=2 THEN
		SET @tva=1.1;
	END IF;

    SELECT sum(total_ligne_ht) INTO @total_commande FROM ligne WHERE ligne.id_commande = NEW.id_commande;
    SET @total_commande=@total_commande*@tva;
    UPDATE commande SET total_commande=@total_commande where commande.id_commande = NEW.id_commande;
  END

3e TRIGGER 

CREATE TRIGGER `before_ligne_insert` BEFORE INSERT ON `ligne`
 FOR EACH ROW 
 BEGIN
 
    set @prix_ht = 0;
	
    SELECT prix_ht INTO @prix_ht FROM produit WHERE produit.id_produit = NEW.id_produit;
    SET NEW.total_ligne_ht = @prix_ht * NEW.qte;
  END

4e TRIGGER

CREATE TRIGGER `before_ligne_update` BEFORE UPDATE ON `ligne`
 FOR EACH ROW
 BEGIN
 
    set @prix_ht = 0;
	
    SELECT prix_ht INTO @prix_ht FROM produit WHERE produit.id_produit = NEW.id_produit;
    SET NEW.total_ligne_ht = @prix_ht * NEW.qte;
  END
