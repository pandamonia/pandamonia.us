require 'bundler'
require "compass"
require "sprockets"
require "zurb-foundation"
require "jekyll-assets"
require "jekyll-assets/compass"
Bundler.require(:default, :production)

run Rack::Jekyll.new
