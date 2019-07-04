format 221

classinstance 128100 class_ref 135012 // Utilisateur
  name ""   xyz 161.151 4.37071 2005 life_line_z 2000
classinstance 128228 class_ref 134884 // Systeme
  name ""   xyz 455.684 4 2000 life_line_z 2000
fragment 129636 "loop"
  xyzwh 359.641 236.529 1995 287 121
end
fragment 130020 "loop"
  xyzwh 379.526 287.015 2000 255 55
end
fragment 130532 "alt"
  xyzwh 44.532 146.371 1990 625 547
  separator 5034
  separator 6873
end
classinstance 131940 class_ref 135140 // EmailServer
  name ""   xyz 704.833 4 2000 life_line_z 2000
note 132836 "[ username
 password ]"
  xyzwh 48.964 172.574 2000 89 54
note 132964 "[ username
 oublié ]"
  xyzwh 48.9209 427.346 2000 86 46
note 133092 "[ password
 oublié ]"
  xyzwh 49.0502 530.87 2000 91 49
durationcanvas 128356 classinstance_ref 128100 // :Utilisateur
  xyzwh 182 63 2010 11 117
end
durationcanvas 128484 classinstance_ref 128228 // :Systeme
  xyzwh 478 63 2010 11 66
end
durationcanvas 128868 classinstance_ref 128228 // :Systeme
  xyzwh 478 162 2010 11 27
end
durationcanvas 129124 classinstance_ref 128228 // :Systeme
  xyzwh 478 199 2010 11 25
end
durationcanvas 129380 classinstance_ref 128228 // :Systeme
  xyzwh 478 245 2010 11 30
end
durationcanvas 129764 classinstance_ref 128228 // :Systeme
  xyzwh 478 300 2010 11 32
end
durationcanvas 130148 classinstance_ref 128228 // :Systeme
  xyzwh 478 378 2010 11 27
end
durationcanvas 130276 classinstance_ref 128100 // :Utilisateur
  xyzwh 182 375 2010 11 33
end
durationcanvas 130660 classinstance_ref 128100 // :Utilisateur
  xyzwh 182 448 2010 11 52
end
durationcanvas 130788 classinstance_ref 128228 // :Systeme
  xyzwh 478 448 2010 11 52
end
durationcanvas 131172 classinstance_ref 128100 // :Utilisateur
  xyzwh 182 547 2010 11 91
end
durationcanvas 131300 classinstance_ref 128228 // :Systeme
  xyzwh 478 547 2010 11 54
end
durationcanvas 131684 classinstance_ref 128228 // :Systeme
  xyzwh 478 608 2010 11 69
end
durationcanvas 132324 classinstance_ref 131940 // :EmailServer
  xyzwh 734 642 2010 11 47
end
durationcanvas 132580 classinstance_ref 128100 // :Utilisateur
  xyzwh 182 659 2010 11 25
end
msg 128612 synchronous
  from durationcanvas_ref 128356
  to durationcanvas_ref 128484
  yz 65 2015 explicitmsg "1. demandePageLogin()"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 266 51
msg 128740 return
  from durationcanvas_ref 128484
  to durationcanvas_ref 128356
  yz 114 2015 explicitmsg "2. afficheFormulaireLogin()"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 258 99
msg 128996 synchronous
  from durationcanvas_ref 128356
  to durationcanvas_ref 128868
  yz 164 2015 explicitmsg "3. envoiLogin(username, password)"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 254 153
reflexivemsg 129252 synchronous
  to durationcanvas_ref 129124
  yz 199 2015 explicitmsg "4. verifieLogin()"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 514 198
reflexivemsg 129508 synchronous
  to durationcanvas_ref 129380
  yz 245 2015 explicitmsg "5. rechercheRole(utilisateur)"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 502 258
reflexivemsg 129892 synchronous
  to durationcanvas_ref 129764
  yz 300 2015 explicitmsg "6. rechercheModule(role)"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 499 314
msg 130404 return
  from durationcanvas_ref 130148
  to durationcanvas_ref 130276
  yz 381 2015 explicitmsg "7. afficheAccueil(utilisateur, modules)"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 251 368
msg 130916 synchronous
  from durationcanvas_ref 130660
  to durationcanvas_ref 130788
  yz 450 2015 explicitmsg "3a. oubliUsername()"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 287 436
msg 131044 return
  from durationcanvas_ref 130788
  to durationcanvas_ref 130660
  yz 484 2015 explicitmsg "3a1. afficheMessage(ContacterAdmin)"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 242 470
msg 131428 synchronous
  from durationcanvas_ref 131172
  to durationcanvas_ref 131300
  yz 549 2015 explicitmsg "3b. oubliPassword()"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 286 534
msg 131556 return
  from durationcanvas_ref 131300
  to durationcanvas_ref 131172
  yz 584 2015 explicitmsg "3b1. afficheFormulairePassword()"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 252 570
msg 131812 synchronous
  from durationcanvas_ref 131172
  to durationcanvas_ref 131684
  yz 626 2020 explicitmsg "3b2. envoiDonnees(username, email)"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 246 611
msg 132452 asynchronous
  from durationcanvas_ref 131684
  to durationcanvas_ref 132324
  yz 644 2015 explicitmsg "3b3. envoiEmail(message)"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 549 628
msg 132708 return
  from durationcanvas_ref 131684
  to durationcanvas_ref 132580
  yz 665 2025 explicitmsg "3b4. afficheMessage(envoiEmail)"
  show_full_operations_definition default show_class_of_operation default drawing_language default show_context_mode default
  label_xy 255 649
end
