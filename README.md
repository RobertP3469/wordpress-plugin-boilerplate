# WordPress Plugin Boilerplate
Bootstrap project for creating new WordPress plugins

# File and Folder Structure
The software architecture of this plugin template uses the 3-tier Architecture advocated in the early years of ASP.NET web development. This is because I began doing web development when ASP.NET first came out in 2001, and old habits are hard to break.

main-plugin-folder
  - bl (business layer logic)
  - dl (data access layer)
  - pl (presentation layer)
    - css (stylesheets)
    - js (scripts)
    
  Since WordPress already has it's own data access libray, I typically use the data access layer folder for API controller files.
