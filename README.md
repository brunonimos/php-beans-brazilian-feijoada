=============Brazilian Feijoada for PHP=============

##Introduction

A PHP implementation of Java Beans.

-All classes can be used as dependency;

-All attributes with the managed bean notation can be acessed from client-side.

##Requirements
-PHP 7;

-JQuery 2.2.1.

##Usage
Instalation.

-Configure the class, file and path in web.xml.

-In html file loadind beans.js use the following sintax in any part (except head):

#{request@class-name.attribute-name}
#{request@class-name.array-name.key}
#{request@class-name.array-name.key.key}

##To do.
-Development of all scopes of Java bean.

##License
-In the license file.