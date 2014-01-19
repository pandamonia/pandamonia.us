# Title: Simple Image tag for Jekyll
# Authors: Brandon Mathis http://brandonmathis.com
#          Felix Schäfer, Frederic Hemberger
# Description: Easily output images with optional class names, width, height, title and alt attributes
#
# Syntax {% img [class name(s)] [http[s]:/]/path/to/image [width [height]] [title text | "title text" ["alt text"]] %}
#
# Examples:
# {% img /images/ninja.png Ninja Attack! %}
# {% img left half http://site.com/images/ninja.png Ninja Attack! %}
# {% img left half http://site.com/images/ninja.png 150 150 "Ninja Attack!" "Ninja in attack posture" %}
#
# Output:
# <img src="/images/ninja.png">
# <img class="left half" src="http://site.com/images/ninja.png" title="Ninja Attack!" alt="Ninja Attack!">
# <img class="left half" src="http://site.com/images/ninja.png" width="150" height="150" title="Ninja Attack!" alt="Ninja in attack posture">
#
# Modified by Alexsander Akers on 6/23/13.
#

module Jekyll

  class ImageTag < Liquid::Tag
    @img = nil

    def initialize(tag_name, markup, tokens)
      attributes = ['class', 'src', 'width', 'height', 'title']

      if markup =~ /(?<class>\S.*\s+)?(?<src>(?:https?:\/\/|\/|\S+\/)\S+)(?:\s+(?<width>\d+))?(?:\s+(?<height>\d+))?(?<title>\s+.+)?/i
        @img = attributes.reduce({}) { |img, attr| img[attr] = $~[attr].strip if $~[attr]; img }
        if /(?:"|')(?<title>[^"']+)?(?:"|')\s+(?:"|')(?<alt>[^"']+)?(?:"|')/ =~ @img['title']
          @img['title']  = title
          @img['alt']    = alt
        else
          @img['alt']    = @img['title'].gsub!(/"/, '&#34;') if @img['title']
        end
        @img['class'].gsub!(/"/, '') if @img['class']
      end

      super
    end

    def render(context)
      site = context.registers[:site]
      
      src = @img['src']
      begin
        @img['src'] = site.asset_path src
      rescue Jekyll::AssetsPlugin::Environment::AssetNotFound => e
        @img['src'] = src
      end

      pathname = Pathname.new(src)
      pathname = pathname.sub_ext('@2x' + pathname.extname)
      begin
        large_asset = site.asset_path pathname.to_s
        @img['data-at2x'] = large_asset
      rescue Jekyll::AssetsPlugin::Environment::AssetNotFound => e
      end

      if @img
        "<img #{@img.collect {|k,v| "#{k}=\"#{v}\"" if v}.join(" ")} />"
      else
        "Error processing input, expected syntax: {% img [class name(s)] [http[s]:/]/path/to/image [width [height]] [title text | \"title text\" [\"alt text\"]] %}"
      end
    end
  end

  module ImageFilter
    def img(markup)
      attributes = ['class', 'src', 'width', 'height', 'title']

      if markup =~ /(?<class>\S.*\s+)?(?<src>(?:https?:\/\/|\/|\S+\/)\S+)(?:\s+(?<width>\d+))?(?:\s+(?<height>\d+))?(?<title>\s+.+)?/i
        image = attributes.reduce({}) { |img, attr| img[attr] = $~[attr].strip if $~[attr]; img }
        if /(?:"|')(?<title>[^"']+)?(?:"|')\s+(?:"|')(?<alt>[^"']+)?(?:"|')/ =~ image['title']
          image['title']  = title
          image['alt']    = alt
        else
          image['alt']    = image['title'].gsub!(/"/, '&#34;') if image['title']
        end
        image['class'].gsub!(/"/, '') if image['class']
      end

      site = @context.registers[:site]
      
      src = image['src']
      begin
        image['src'] = site.asset_path src
      rescue Jekyll::AssetsPlugin::Environment::AssetNotFound => e
        image['src'] = src
      end

      pathname = Pathname.new(src)
      pathname = pathname.sub_ext('@2x' + pathname.extname)
      begin
        large_asset = site.asset_path pathname.to_s
        image['data-at2x'] = large_asset
      rescue Jekyll::AssetsPlugin::Environment::AssetNotFound => e
      end

      if image
        "<img #{image.collect {|k,v| "#{k}=\"#{v}\"" if v}.join(" ")} />"
      else
        "Error processing input, expected syntax: {% img [class name(s)] [http[s]:/]/path/to/image [width [height]] [title text | \"title text\" [\"alt text\"]] %}"
      end
    end
  end

end

Liquid::Template.register_tag('img', Jekyll::ImageTag)
Liquid::Template.register_filter(Jekyll::ImageFilter)