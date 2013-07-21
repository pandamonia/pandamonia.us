# Change your GitHub reponame
GITHUB_REPONAME = "pandamonia/pandamonia.us"


desc "Generate blog files"
task :generate do
  require 'jekyll'
  Jekyll::Site.new(Jekyll.configuration({
    "source"      => ".",
    "destination" => "_site"
  })).process
end


desc "Generate and publish blog to gh-pages"
task :publish => [:generate] do
  require 'tmpdir'
  Dir.mktmpdir do |tmp|
    cp_r "_site/.", tmp
    Dir.chdir tmp
    system "git init"
    system "git add ."
    message = "Site generated at #{Time.now.utc}"
    system "git commit -m #{message.shellescape}"
    system "git remote add origin https://github.com/#{GITHUB_REPONAME}.git"
    system "git push -f -u origin HEAD:gh-pages"
  end
end
