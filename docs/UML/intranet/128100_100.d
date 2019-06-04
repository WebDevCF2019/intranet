format 221

classcanvas 128100 class_ref 128100 // Referent
  simpleclassdiagramsettings end
  xyz 120 191 2000
end
subject 128228 ""
  xyzwh 239 17 2000 545 627
usecasecanvas 128356 usecase_ref 128100 // Sélectionner Stagiaire
  xyzwh 291 213 3005 133 67 label_xy 307 237
end
usecasecanvas 128484 usecase_ref 128228 // Imprimer FicheSuivi
  xyzwh 364 366 3005 133 57 label_xy 386 385
end
usecasecanvas 128612 usecase_ref 128356 // S'authentifier
  xyzwh 642 202 3005 115 57 label_xy 670 222
end
usecasecanvas 129252 usecase_ref 128484 // Gérer EtatSuivi
  xyzwh 420 88 3005 113 67 label_xy 439 103
end
classcanvas 129764 class_ref 128228 // AdminPedago
  simpleclassdiagramsettings end
  xyz 109 500 2000
end
usecasecanvas 129892 usecase_ref 128612 // Gérer CritèreSuivi
  xyzwh 559 538 3005 133 69 label_xy 581 556
end
classcanvas 130276 class_ref 128356 // Employe
  simpleclassdiagramsettings end
  xyz 35 341 2000
end
packagecanvas 130660 
  package_ref 128100 // Pedagogique
    xyzwh 270 34 2005 289 409
end
packagecanvas 130788 
  package_ref 128356 // Configuration
    xyzwh 509 494 3011 241 131
end
packagecanvas 130916 
  package_ref 128228 // Utilitaire
    xyzwh 608 122 2000 161 183
end
line 128740 ----
  from ref 128100 z 3006 to ref 128484
simplerelationcanvas 128996 simplerelation_ref 128228
  from ref 128484 z 3006 stereotype "<<include>>" xyz 530 311 3000 to ref 128612
end
simplerelationcanvas 129124 simplerelation_ref 128356
  from ref 128484 z 3006 stereotype "<<include>>" xyz 364 321 3000 to ref 128356
end
simplerelationcanvas 129380 simplerelation_ref 128484
  from ref 129252 z 3006 stereotype "<<include>>" xyz 558 174 3000 to ref 128612
end
simplerelationcanvas 129508 simplerelation_ref 128612
  from ref 129252 z 3006 stereotype "<<include>>" xyz 384 183 3000 to ref 128356
end
line 129636 ----
  from ref 128100 z 3006 to ref 129252
line 130020 ----
  from ref 129764 z 3006 to ref 129892
simplerelationcanvas 130148 simplerelation_ref 128740
  from ref 129892 z 3006 stereotype "<<include>>" xyz 632 397 3000 to ref 128612
end
relationcanvas 130404 relation_ref 128100 // <generalisation>
  from ref 129764 z 2001 to ref 130276
  no_role_a no_role_b
  no_multiplicity_a no_multiplicity_b
end
relationcanvas 130532 relation_ref 128228 // <generalisation>
  from ref 128100 z 2001 to ref 130276
  no_role_a no_role_b
  no_multiplicity_a no_multiplicity_b
end
end
