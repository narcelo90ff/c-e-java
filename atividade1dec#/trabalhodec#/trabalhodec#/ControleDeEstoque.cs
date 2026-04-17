using System;
using System.Collections.Generic;
using System.Linq;

public class ItemEstoque
{
    public int Id { get; set; }
    public string Nome { get; set; }
    public int Quantidade { get; set; }
}

public class EstoqueService
{
    private List<ItemEstoque> _estoque = new List<ItemEstoque>();

    public void AdicionarItem(ItemEstoque item)
    {
        _estoque.Add(item);
    }

    public void DarBaixa(int id, int quantidadeParaRetirar)
    {
        var item = _estoque.FirstOrDefault(i => i.Id == id);

        if (item == null)
        {
            Console.WriteLine($"[ERRO] Item com ID {id} não encontrado.");
            return;
        }

        if (item.Quantidade < quantidadeParaRetirar)
        {
            Console.WriteLine($"[BLOQUEADO] Baixa de {quantidadeParaRetirar} un. impossível para '{item.Nome}'. Estoque atual: {item.Quantidade}.");
        }
        else
        {
            item.Quantidade -= quantidadeParaRetirar;
            Console.WriteLine($"[SUCESSO] Baixa de {quantidadeParaRetirar} un. realizada para '{item.Nome}'. Novo saldo: {item.Quantidade}.");
        }
    }

    public List<ItemEstoque> ListarEstoqueBaixo(int limite)
    {
        return _estoque.Where(i => i.Quantidade < limite).ToList();
    }

    public List<ItemEstoque> ListarTodos() => _estoque;
}

// --- EXECUÇÃO (MAIN) ---
class Program
{
    static void Main()
    {
        var service = new EstoqueService();

        service.AdicionarItem(new ItemEstoque { Id = 1, Nome = "Caderno", Quantidade = 15 });
        service.AdicionarItem(new ItemEstoque { Id = 2, Nome = "Lápis", Quantidade = 3 });
        service.AdicionarItem(new ItemEstoque { Id = 3, Nome = "Borracha", Quantidade = 20 });

        Console.WriteLine("--- Movimentação de Estoque ---");
        service.DarBaixa(1, 5);  // Deve funcionar (sobra 10)
        service.DarBaixa(2, 10); // Deve ser bloqueado (só tem 3)

        Console.WriteLine("\n--- Relatório: Estoque Baixo (Limite: 5) ---");
        var baixoEstoque = service.ListarEstoqueBaixo(5);
        
        if (baixoEstoque.Count == 0)
        {
            Console.WriteLine("Tudo em ordem no estoque.");
        }
        else
        {
            foreach (var i in baixoEstoque)
            {
                Console.WriteLine($"ALERTA: {i.Nome} possui apenas {i.Quantidade} unidades!");
            }
        }
    }
}
