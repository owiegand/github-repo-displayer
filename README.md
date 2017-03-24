# github-repo-displayer
This is PHP library that allows users to pull custom information from their repositories automatically. This code was written to intergrated into personal sites to display basic information and links to Github repos. This libaray doesn't enforce any particluar use case though.



## Usage
While the libaray can extract basic data for each repo from the Github API, users including myself might want to have more control over the specific content returned for each repository. Shown below is the syntax used to add extra details to your repositories. This needs to be added in the README.md file for each repository. This libaray doesn't require all or any of these properties to be used. We surround the code in a comment block so that it doesn't show up when looking at the README file (only in the raw version).

```
<!--
[**GITHUBPARSER**]
{
  "AltShortDesc": "This is the Short DESC",
  "LongDesc": "This is the Ling DSEC",
  "ImgURL": "http://www.google.com",
  "ThumbailImgURL": "http://www.google.org",
  "Category": "Test Category\n"
}
[**GITHUBPARSER**]
-->
```

### Notice
This libaray doesn't provide anyway to cache the results returned. If this going to be used on a site, the results returned from this libaray should be cached and updated daily as not to overload Github's API with unnecessary calls.


## Updates
Updates to this libaray will be made if there is a bug found or something changes with the Github API. Please open an issue on Github for all bugs/issues found.
