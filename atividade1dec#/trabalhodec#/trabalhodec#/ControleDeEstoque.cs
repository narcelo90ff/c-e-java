using System;
using System.Collections.Generic;
using System.Linq;

namespace AtividadesCSharp
{
    public class Produto
    {
        public int Id { get; set; }
        public string Nome { get; set; }
        public double Preco { get; set; }
    }

    public class ProdutoService
    {
        private List<Produto> _produtos = new List<Produto>();

        public void Criar(Produto p) => _produtos.Add(p);
        public List<Produto> ListarTodos() => _produtos;
        
        public List<Produto> ListarAcimaDe(double valorMinimo) 
            => _produtos.Where(p => p.Preco > valorMinimo).ToList();
    }
