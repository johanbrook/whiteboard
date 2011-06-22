require "rake"
require "sprockets"
require "tempfile"

WB_ROOT = File.expand_path(File.dirname(__FILE__))
WB_JS_DIR = File.join(WB_ROOT, 'resources/javascripts')

MAIN_JS_FILE = File.join(WB_JS_DIR, "whiteboard.js")
MAIN_CSS_FILE = File.join(WB_ROOT, "style.css")

task :default => ["css:all", "javascript:all"]

namespace :css do
  task :all => [:sass, :header] do
  end
  
  desc "Make sure the master Sass file is compiled"
  task :sass do
    puts `compass compile . -e production --force`
    puts "* Sass compiled to 'style.css'"
    Rake::Task["css:header"].execute
  end
  
  desc "Add the WP header to the compressed file"
  task :header do
    add_wp_header(MAIN_CSS_FILE)
    puts "* The WP header was added to #{File.basename MAIN_CSS_FILE}"
  end
  
end
  
  
namespace :javascript do
  
  task :all => [:concat, :minify] do
    end
  
  desc "Strip trailing whitespace and ensure each file ends with a newline"
  task :whitespace do
    puts "* Normalizing whitespace ..."
    Dir[WB_JS_DIR + "*/**"].each do |filename|
      normalize_whitespace(filename) if File.file?(filename)
    end
  end


  desc "Concatenate all JS files"
  task :concat => :whitespace do
    secretary = Sprockets::Secretary.new(
      :load_path => [WB_JS_DIR, File.join(WB_JS_DIR, "library")],
      :source_files => [File.join(WB_JS_DIR, MAIN_JS_FILE)]
    )

    title = (ENV["title"] == nil) ? "all.js" : ENV["title"]

    secretary.concatenation.save_to File.join(WB_JS_DIR, title)
    puts "* Mashed together all JS files into '#{title}'"

  end


  desc "Generates a minified version for distribution, using Closure Compiler."
  task :minify do    
    js_file = (ENV["FILE"] == nil) ? "all.js" : ENV["FILE"]

    raise "No FILE given" if js_file == nil

    src, target = File.join(WB_JS_DIR, js_file), File.join(WB_JS_DIR, output_filename(js_file))
    google_compiler src, target
  end
  
end


#-----------------------------------------------------------------

# Add the WP header to the top of the compressed CSS file:
def add_wp_header(file)
  header = <<-HTML
/*
Theme Name: Whiteboard
Theme URI: n/a
Description: Boilerplate theme
Author: Johan Brook
Author URI: http://johanbrook.com
Version: 1.0

*/

HTML
  
  File.prepend(file, header)
end


# /javascript/application.js => /javascript/application.min.js
def output_filename(js_file)
  output_file = File.basename(js_file, File.extname(js_file))
  output_file = File.join(File.dirname(js_file), output_file)
  return output_file + ".min" + File.extname(js_file)
end


def normalize_whitespace(filename)
  contents = File.readlines(filename)
  contents.each { |line| line.sub!(/\s+$/, "") }
  File.open(filename, "w") do |file|
    file.write contents.join("\n").sub(/(\n+)?\Z/m, "\n")
  end
end


def google_compiler(src, target)
  puts "Minifying #{src} with Google Closure Compiler..."
  `java -jar #{WB_JS_DIR}/compressors/google-compiler/compiler.jar --js #{src} --summary_detail_level 3 --js_output_file #{target}`
end


def uglifyjs(src, target)
  begin
    require 'uglifier'
  rescue LoadError => e
    if verbose
      puts "\nYou'll need the 'uglifier' gem for minification. Just run:\n\n"
      puts "  $ gem install uglifier"
      puts "\nand you should be all set.\n\n"
      exit
    end
    return false
  end
  puts "Minifying #{File.basename(src)} with UglifyJS..."
  File.open(target, "w"){|f| f.puts Uglifier.new.compile(File.read(src))}
  puts "* Minified into '#{File.basename(target)}'"
end



class File
  def self.prepend(path, string)
    Tempfile.open File.basename(path) do |tempfile|
      # prepend data to tempfile
      tempfile << string

      File.open(path, 'r+') do |file|
        # append original data to tempfile
        tempfile << file.read
        # reset file positions
        file.pos = tempfile.pos = 0
        # copy all data back to original file
        file << tempfile.read
      end
    end
  end
end

