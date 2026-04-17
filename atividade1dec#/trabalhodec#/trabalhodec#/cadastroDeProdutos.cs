using System;
using System.Collections.Generic;
using System.Linq;

public class Produto
{
    public int Id { get; set; }
    public string Nome { get; set; }
    public double Preco { get; set; }
}

public class ProdutoRepository
{
    private List<Produto> _produtos = new List<Produto>();

    public void Inserir(Produto p) => _produtos.Add(p);

    public List<Produto> ListarTodos() => _produtos;

    public Produto ObterPorId(int id) => _produtos.FirstOrDefault(p => p.Id == id);

    public void Atualizar(int id, Produto pAtualizado)
    {
        var existente = ObterPorId(id);
        if (existente != null)
        {
            existente.Nome = pAtualizado.Nome;
            existente.Preco = pAtualizado.Preco;
        }
    }

    public void Excluir(int id) => _produtos.RemoveAll(p => p.Id == id);
    
    public List<Produto> ListarAcimaDe(double precoMinimo) 
        => _produtos.Where(p => p.Preco > precoMinimo).ToList();
}

class Program
{
    static void Main()
    {
        var repo = new ProdutoRepository();

        repo.Inserir(new Produto { Id = 1, Nome = "Mouse Pad Gamer", Preco = 45.90 });
        repo.Inserir(new Produto { Id = 2, Nome = "Teclado Mecânico", Preco = 280.00 });
        repo.Inserir(new Produto { Id = 3, Nome = "Headset USB", Preco = 150.00 });

        Console.WriteLine("=== Lista de Produtos ===");
        var lista = repo.ListarTodos();
        foreach (var p in lista)
        {
            Console.WriteLine($"ID: {p.Id} | Nome: {p.Nome} | Preço: R$ {p.Preco:F2}");
        }

        Console.WriteLine("\n=== Produtos Acima de R$ 100,00 ===");
        var caros = repo.ListarAcimaDe(100.00);
        caros.ForEach(p => Console.WriteLine($"- {p.Nome} (R$ {p.Preco:F2})"));
    }
}
