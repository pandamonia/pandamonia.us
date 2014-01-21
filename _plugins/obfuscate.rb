module Jekyll
  class ObfuscateTag < Liquid::Tag
    @@prng = Random.new

    def initialize(tag_name, text, tokens)
      @text = text.chomp
      super
    end

    def render(context)
      @text.chars.map do |char|
        case @@prng.rand(0..2)
          when 0
            char
          when 1
            "&##{char.ord};"
          when 2
            "&#x#{char.ord.to_s(16)};"
        end
      end
    end
  end
end

Liquid::Template.register_tag('obfuscate', Jekyll::ObfuscateTag)