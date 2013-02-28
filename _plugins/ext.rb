# require 'sassy-math'
# require 'modular-scale'
require 'zurb-foundation'

require 'sass'
require 'uglifier'

require 'jekyll-assets/compass'
require 'jekyll-assets'

# https://github.com/ixti/jekyll-assets/issues/16#issuecomment-13908709
# 
# Taken from Ruby On Rails:
# https://raw.github.com/rails/rails/3-0-stable/activesupport/lib/active_support/core_ext/kernel/singleton_class.rb
module Kernel
  # Returns the object's singleton class.
  def singleton_class
    class << self
      self
    end
  end unless respond_to?(:singleton_class) # exists in 1.9.2

  # class_eval on an object acts like singleton_class.class_eval.
  def class_eval(*args, &block)
    singleton_class.class_eval(*args, &block)
  end
end